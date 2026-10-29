<?php

namespace Tests\Unit\Support;

use App\Support\MailLogo;
use Illuminate\Mail\Message;
use Symfony\Component\Mime\Email;
use Tests\TestCase;

class MailLogoTest extends TestCase
{
    public function test_public_url_uses_the_configured_application_url(): void
    {
        config(['app.url' => 'https://byphealthtek.com']);

        $this->assertSame(
            'https://byphealthtek.com/brand/images/logo.png',
            MailLogo::publicUrl()
        );
    }

    public function test_public_url_uses_https_in_production(): void
    {
        $this->app['env'] = 'production';
        config(['app.url' => 'http://byphealthtek.com']);

        $this->assertSame(
            'https://byphealthtek.com/brand/images/logo.png',
            MailLogo::publicUrl()
        );
    }

    public function test_src_inlines_the_png_without_a_mail_message(): void
    {
        $src = MailLogo::src();

        $this->assertStringStartsWith('data:image/png;base64,', $src);
        $this->assertNotSame(MailLogo::publicUrl(), $src);
    }

    public function test_src_embeds_the_png_when_a_mail_message_is_available(): void
    {
        $message = new Message(new Email);

        $src = MailLogo::src($message);

        $this->assertStringStartsWith('cid:', $src);
        $this->assertNotSame(MailLogo::publicUrl(), $src);
        $this->assertCount(1, $message->getSymfonyMessage()->getAttachments());
    }

    public function test_src_reuses_the_same_cid_for_the_same_message(): void
    {
        $message = new Message(new Email);

        $first = MailLogo::src($message);
        $second = MailLogo::src($message);

        $this->assertSame($first, $second);
        $this->assertCount(1, $message->getSymfonyMessage()->getAttachments());
    }
}
