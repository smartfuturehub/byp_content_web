<?php

namespace App\Livewire;

use App\Mail\LeadSubmitted;
use App\Mail\LeadThankYou;
use App\Models\Lead;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;
use Throwable;

class LeadForm extends Component
{
    public string $type = 'contact';

    public bool $showPhone = true;

    public bool $showCompany = true;

    public bool $showCountry = false;

    public bool $showLastName = true;

    public bool $showMessage = true;

    public bool $emailOnly = false;

    public string $buttonLabel = 'Submit';

    public string $placeholder = 'Enter your email';

    public string $name = '';

    public string $lastName = '';

    public string $email = '';

    public string $phone = '';

    public string $company = '';

    public string $country = '';

    public string $message = '';

    public string $captchaQuestion = '';

    public string $captchaToken = '';

    public string $captchaAnswer = '';

    /** Honeypot — must stay empty. */
    public string $website = '';

    public bool $submitted = false;

    public function mount(): void
    {
        $this->refreshCaptcha();
    }

    public function refreshCaptcha(): void
    {
        $left = random_int(1, 9);
        $right = random_int(1, 9);

        $this->captchaQuestion = "{$left} + {$right}";
        $this->captchaToken = Str::random(40);
        $this->captchaAnswer = '';

        cache()->put($this->captchaCacheKey(), $left + $right, now()->addMinutes(30));
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        $rules = [
            'email' => ['required', 'email', 'max:255', $this->uniqueEmailRule()],
        ];

        if (! $this->emailOnly) {
            $rules['name'] = 'required|string|max:120';
            $rules['message'] = 'nullable|string|max:300';
            $rules['captchaAnswer'] = 'required|string|max:10';

            if ($this->showLastName) {
                $rules['lastName'] = 'required|string|max:120';
            }

            if ($this->showCountry) {
                $rules['country'] = 'required|string|max:120';
            }
        }

        return $rules;
    }

    public function updated(string $property): void
    {
        if ($property === 'email') {
            $this->email = Str::lower(trim($this->email));
        }

        if (array_key_exists($property, $this->rules())) {
            $this->validateOnly($property, $this->rules(), $this->messages());
        }
    }

    public function submit(): void
    {
        if (filled($this->website)) {
            $this->submitted = true;
            $this->reset(['name', 'lastName', 'email', 'phone', 'company', 'country', 'message', 'captchaAnswer', 'website']);
            $this->refreshCaptcha();

            return;
        }

        $this->email = Str::lower(trim($this->email));

        $this->validate($this->rules(), $this->messages());

        if (! $this->emailOnly && ! $this->captchaIsValid()) {
            $this->addError('captchaAnswer', 'Please solve the captcha correctly.');
            $this->refreshCaptcha();

            return;
        }

        try {
            $fullName = trim($this->name.' '.$this->lastName);

            $lead = Lead::query()->create([
                'type' => $this->type,
                'name' => $fullName !== '' ? $fullName : null,
                'email' => $this->email,
                'phone' => $this->phone ?: null,
                'company' => $this->company ?: null,
                'message' => $this->message ?: null,
                'page_url' => url()->previous(),
                'meta' => filled($this->country) ? ['country' => $this->country] : null,
                'status' => 'new',
            ]);
        } catch (UniqueConstraintViolationException) {
            $this->addError('email', $this->duplicateEmailMessage());
            $this->refreshCaptcha();

            return;
        }

        $this->notifyVisitor($lead);
        $this->notifyTeam($lead);

        $this->submitted = true;
        $this->reset(['name', 'lastName', 'email', 'phone', 'company', 'country', 'message', 'captchaAnswer', 'website']);
        $this->refreshCaptcha();
    }

    protected function captchaIsValid(): bool
    {
        $expected = cache()->pull($this->captchaCacheKey());

        if ($expected === null) {
            return false;
        }

        return (int) trim($this->captchaAnswer) === (int) $expected;
    }

    protected function captchaCacheKey(): string
    {
        return 'lead-form-captcha:'.$this->captchaToken;
    }

    public function render()
    {
        return view('livewire.lead-form');
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'email.unique' => $this->duplicateEmailMessage(),
            'captchaAnswer.required' => 'Please solve the captcha.',
        ];
    }

    protected function uniqueEmailRule(): Unique
    {
        return Rule::unique('leads', 'email')->where('type', $this->type);
    }

    protected function duplicateEmailMessage(): string
    {
        return $this->type === 'newsletter'
            ? 'This email is already subscribed.'
            : 'This email has already been used to contact us.';
    }

    protected function notifyVisitor(Lead $lead): void
    {
        if (! filled($lead->email)) {
            return;
        }

        try {
            Mail::to($lead->email)->send(new LeadThankYou($lead));
        } catch (Throwable $exception) {
            report($exception);
            Log::error('Lead thank-you email failed.', [
                'lead_id' => $lead->getKey(),
                'to' => $lead->email,
                'mailer' => config('mail.default'),
                'message' => $exception->getMessage(),
            ]);
        }
    }

    protected function notifyTeam(Lead $lead): void
    {
        if ($this->emailOnly) {
            return;
        }

        $notificationEmail = config('mail.lead_notification.address');

        if (! filled($notificationEmail)) {
            return;
        }

        try {
            Mail::send(new LeadSubmitted($lead));
        } catch (Throwable $exception) {
            report($exception);
            Log::error('Contact Us HTML email failed; sending a plain-text copy.', [
                'lead_id' => $lead->getKey(),
                'to' => $notificationEmail,
                'bcc' => config('mail.lead_notification.bcc', []),
                'mailer' => config('mail.default'),
                'message' => $exception->getMessage(),
            ]);

            $this->notifyTeamWithPlainText($notificationEmail, $lead);
        }
    }

    protected function notifyTeamWithPlainText(string $notificationEmail, Lead $lead): void
    {
        $country = data_get($lead->meta, 'country') ?: '—';
        $fromName = $lead->name ?: $lead->email;
        $bcc = array_values(array_filter(config('mail.lead_notification.bcc', [])));
        $body = implode("\n", [
            'A visitor submitted the Contact Us form.',
            '',
            'Name: '.($lead->name ?: '—'),
            'Email: '.$lead->email,
            'Phone: '.($lead->phone ?: '—'),
            'Organisation: '.($lead->company ?: '—'),
            'Country: '.$country,
            'Page: '.($lead->page_url ?: '—'),
            'Message: '.($lead->message ?: '—'),
        ]);

        try {
            Mail::raw($body, function ($message) use ($notificationEmail, $fromName, $bcc, $lead): void {
                $message->to($notificationEmail)->subject('New contact request from '.$fromName);

                if ($bcc !== []) {
                    $message->bcc($bcc);
                }

                if (filled($lead->email)) {
                    $message->replyTo($lead->email, $fromName);
                }
            });
        } catch (Throwable $exception) {
            report($exception);
            Log::error('Contact Us plain-text email failed.', [
                'lead_id' => $lead->getKey(),
                'to' => $notificationEmail,
                'bcc' => config('mail.lead_notification.bcc', []),
                'mailer' => config('mail.default'),
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
