<?php

namespace Tests\Feature;

use App\Livewire\LeadForm;
use App\Mail\LeadSubmitted;
use App\Mail\LeadThankYou;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class LeadFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param  \Livewire\Features\SupportTesting\Testable  $component
     */
    protected function solveCaptcha($component): void
    {
        $question = (string) $component->get('captchaQuestion');

        $this->assertMatchesRegularExpression('/^(\d+) \+ (\d+)$/', $question);

        preg_match('/^(\d+) \+ (\d+)$/', $question, $matches);

        $component->set('captchaAnswer', (string) ((int) $matches[1] + (int) $matches[2]));
    }

    public function test_contact_form_stores_first_and_last_name(): void
    {
        $component = Livewire::test(LeadForm::class)
            ->set('name', 'Amina')
            ->set('lastName', 'Diallo')
            ->set('email', 'amina@example.com');

        $this->solveCaptcha($component);

        $component
            ->call('submit')
            ->assertSet('submitted', true);

        $lead = Lead::query()->where('email', 'amina@example.com')->first();

        $this->assertNotNull($lead);
        $this->assertSame('Amina Diallo', $lead->name);
        $this->assertModelExists($lead);
    }

    public function test_contact_form_emails_the_configured_notification_address(): void
    {
        Mail::fake();

        $component = Livewire::test(LeadForm::class)
            ->set('name', 'Amina Diallo')
            ->set('email', 'amina@example.com')
            ->set('phone', '+221 77 000 0000')
            ->set('company', 'Dakar Clinic')
            ->set('lastName', 'Diallo')
            ->set('message', 'We need a hospital-at-home pilot.');

        $this->solveCaptcha($component);

        $component
            ->call('submit')
            ->assertSet('submitted', true);

        Mail::assertSent(LeadSubmitted::class, function (LeadSubmitted $mail): bool {
            return $mail->hasTo('sales@byphealthtek.com')
                && $mail->hasBcc('sales@oursmartfuture.com')
                && $mail->hasBcc('jaydip@oursmartfuture.com')
                && $mail->hasReplyTo('amina@example.com');
        });
    }

    public function test_contact_form_emails_a_thank_you_to_the_visitor(): void
    {
        Mail::fake();

        $component = Livewire::test(LeadForm::class)
            ->set('name', 'Amina Diallo')
            ->set('email', 'amina@example.com')
            ->set('lastName', 'Diallo');

        $this->solveCaptcha($component);

        $component
            ->call('submit')
            ->assertSet('submitted', true);

        Mail::assertSent(LeadThankYou::class, function (LeadThankYou $mail): bool {
            return $mail->hasTo('amina@example.com');
        });
    }

    public function test_contact_form_validates_email_as_it_is_updated(): void
    {
        Livewire::test(LeadForm::class)
            ->set('email', 'not-an-email')
            ->assertHasErrors(['email'])
            ->assertSet('submitted', false);
    }

    public function test_contact_form_requires_a_last_name(): void
    {
        Mail::fake();

        $component = Livewire::test(LeadForm::class)
            ->set('name', 'Amina')
            ->set('email', 'amina@example.com');

        $this->solveCaptcha($component);

        $component
            ->call('submit')
            ->assertHasErrors(['lastName'])
            ->assertSet('submitted', false);

        $this->assertNull(Lead::query()->where('email', 'amina@example.com')->first());

        Mail::assertNothingSent();
    }

    public function test_contact_form_requires_a_correct_math_captcha(): void
    {
        Mail::fake();

        Livewire::test(LeadForm::class)
            ->set('name', 'Amina Diallo')
            ->set('email', 'amina@example.com')
            ->set('lastName', 'Diallo')
            ->set('captchaAnswer', '999')
            ->call('submit')
            ->assertHasErrors(['captchaAnswer'])
            ->assertSet('submitted', false);

        $this->assertNull(Lead::query()->where('email', 'amina@example.com')->first());

        Mail::assertNothingSent();
    }

    public function test_contact_form_honeypot_is_silently_ignored(): void
    {
        Mail::fake();

        $component = Livewire::test(LeadForm::class)
            ->set('name', 'Bot')
            ->set('email', 'bot@example.com')
            ->set('lastName', 'Bot')
            ->set('website', 'http://spam.example');

        $this->solveCaptcha($component);

        $component
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertNull(Lead::query()->where('email', 'bot@example.com')->first());

        Mail::assertNothingSent();
    }

    public function test_newsletter_subscribe_stores_an_email_lead(): void
    {
        Mail::fake();

        Livewire::test(LeadForm::class, [
            'type' => 'newsletter',
            'emailOnly' => true,
            'buttonLabel' => 'Subscribe',
        ])
            ->set('email', 'Reader@example.com')
            ->call('submit')
            ->assertSet('submitted', true);

        $lead = Lead::query()->where('email', 'reader@example.com')->first();

        $this->assertNotNull($lead);
        $this->assertSame('newsletter', $lead->type);

        Mail::assertSent(LeadThankYou::class, function (LeadThankYou $mail): bool {
            return $mail->hasTo('reader@example.com');
        });
        Mail::assertNotSent(LeadSubmitted::class);
    }

    public function test_newsletter_form_shows_a_subscribing_loading_state(): void
    {
        Livewire::test(LeadForm::class, [
            'type' => 'newsletter',
            'emailOnly' => true,
            'buttonLabel' => 'Subscribe',
        ])
            ->assertSee('Subscribe')
            ->assertSee('Subscribing...')
            ->assertSee('animate-spin', false);
    }

    public function test_contact_form_shows_a_sending_loading_state(): void
    {
        Livewire::test(LeadForm::class)
            ->assertSee('Sending...')
            ->assertSee('animate-spin', false);
    }

    public function test_newsletter_rejects_a_duplicate_email(): void
    {
        Mail::fake();

        Lead::query()->create([
            'type' => 'newsletter',
            'email' => 'reader@example.com',
            'status' => 'new',
        ]);

        Livewire::test(LeadForm::class, [
            'type' => 'newsletter',
            'emailOnly' => true,
        ])
            ->set('email', 'Reader@example.com')
            ->call('submit')
            ->assertHasErrors(['email'])
            ->assertSee('This email is already subscribed.')
            ->assertSet('submitted', false);

        $this->assertSame(1, Lead::query()->where('email', 'reader@example.com')->count());

        Mail::assertNothingSent();
    }

    public function test_contact_form_rejects_a_duplicate_email(): void
    {
        Mail::fake();

        Lead::query()->create([
            'type' => 'contact',
            'name' => 'Amina Diallo',
            'email' => 'amina@example.com',
            'status' => 'new',
        ]);

        $component = Livewire::test(LeadForm::class)
            ->set('name', 'Amina Diallo')
            ->set('email', 'amina@example.com')
            ->set('lastName', 'Diallo');

        $this->solveCaptcha($component);

        $component
            ->call('submit')
            ->assertHasErrors(['email'])
            ->assertSee('This email has already been used to contact us.')
            ->assertSet('submitted', false);

        $this->assertSame(1, Lead::query()->where('email', 'amina@example.com')->count());

        Mail::assertNothingSent();
    }

    public function test_contact_form_accepts_an_email_already_used_for_the_newsletter(): void
    {
        Mail::fake();

        Lead::query()->create([
            'type' => 'newsletter',
            'email' => 'amina@example.com',
            'status' => 'new',
        ]);

        $component = Livewire::test(LeadForm::class)
            ->set('name', 'Amina Diallo')
            ->set('email', 'amina@example.com')
            ->set('lastName', 'Diallo');

        $this->solveCaptcha($component);

        $component
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertSame(2, Lead::query()->where('email', 'amina@example.com')->count());

        Mail::assertSent(LeadThankYou::class, function (LeadThankYou $mail): bool {
            return $mail->hasTo('amina@example.com');
        });
    }

    public function test_lead_email_includes_the_enquiry_details(): void
    {
        $lead = Lead::query()->create([
            'type' => 'contact',
            'name' => 'Amina Diallo',
            'email' => 'amina@example.com',
            'phone' => '+221 77 000 0000',
            'company' => 'Dakar Clinic',
            'message' => 'We need a hospital-at-home pilot.',
            'page_url' => 'http://127.0.0.1:8000/contact-us',
            'meta' => ['country' => 'Senegal'],
            'status' => 'new',
        ]);

        $mailable = new LeadSubmitted($lead);

        $mailable->assertHasSubject('New contact request from Amina Diallo');
        $mailable->assertTo('sales@byphealthtek.com');
        $mailable->assertHasBcc('sales@oursmartfuture.com');
        $mailable->assertHasBcc('jaydip@oursmartfuture.com');
        $mailable->assertSeeInHtml('New contact request');
        $mailable->assertSeeInHtml('Amina Diallo');
        $mailable->assertSeeInHtml('amina@example.com');
        $mailable->assertSeeInHtml('Dakar Clinic');
        $mailable->assertSeeInHtml('Senegal');
        $mailable->assertSeeInHtml('We need a hospital-at-home pilot.');
        $mailable->assertSeeInHtml('alt="BYP Health"', false);
        $mailable->assertSeeInText('Amina Diallo');
    }

    public function test_newsletter_thank_you_email_uses_the_branded_template(): void
    {
        $lead = Lead::query()->create([
            'type' => 'newsletter',
            'email' => 'reader@example.com',
            'status' => 'new',
        ]);

        $mailable = new LeadThankYou($lead);

        $mailable->assertHasSubject('Thank you for subscribing to BYP Health');
        $mailable->assertSeeInHtml('News and Insights');
        $mailable->assertSeeInHtml('alt="BYP Health"', false);
        $mailable->assertSeeInText('News and Insights');

        $html = $mailable->render();
        $this->assertSame(1, preg_match('/<img[^>]+src="([^"]+)"/i', $html, $matches));
        $this->assertStringStartsWith('data:image/png;base64,', html_entity_decode($matches[1]));
    }

    public function test_contact_thank_you_email_uses_the_visitor_name(): void
    {
        $lead = Lead::query()->create([
            'type' => 'contact',
            'name' => 'Amina Diallo',
            'email' => 'amina@example.com',
            'status' => 'new',
        ]);

        $mailable = new LeadThankYou($lead);

        $mailable->assertHasSubject('Thank you for contacting BYP Health');
        $mailable->assertSeeInHtml('Amina Diallo');
        $mailable->assertSeeInHtml('alt="BYP Health"', false);
        $mailable->assertSeeInText('Amina Diallo');
    }

    public function test_thank_you_email_escapes_dangerous_content_in_the_name(): void
    {
        $lead = Lead::query()->create([
            'type' => 'contact',
            'name' => "O'Reilly <script>alert('xss')</script>",
            'email' => 'amina@example.com',
            'status' => 'new',
        ]);

        $content = (new LeadThankYou($lead))->render();

        $this->assertStringContainsString('&lt;script&gt;', $content);
        $this->assertStringNotContainsString("<script>alert('xss')</script>", $content);
    }
}
