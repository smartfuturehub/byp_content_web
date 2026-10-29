@php
    $mailLogoSrc = \App\Support\MailLogo::src($message ?? null);
@endphp
<x-mail::message :logo-src="$mailLogoSrc">
@if($lead->type === 'newsletter')
# Thank you for subscribing

@if(filled($lead->name))
Hi {{ $lead->name }},
@else
Hello,
@endif

You are now subscribed to BYP Health News and Insights. We will send articles, research, and updates on remote patient monitoring and connected care.

<x-mail::button :url="url('/blog')">
Read the latest articles
</x-mail::button>
@else
# Thank you for contacting us

@if(filled($lead->name))
Hi {{ $lead->name }},
@else
Hello,
@endif

We have received your enquiry and will be in touch shortly.

<x-mail::button :url="url('/')">
Visit BYP Health
</x-mail::button>
@endif

Thanks,<br>
The BYP Health team
</x-mail::message>
