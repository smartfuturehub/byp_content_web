@php
    $mailLogoSrc = \App\Support\MailLogo::src($message ?? null);
    $country = data_get($lead->meta, 'country') ?: '—';
@endphp
<x-mail::message :logo-src="$mailLogoSrc">
# New contact request

A visitor submitted the **Contact Us** form on the BYP Health website.

<x-mail::panel>
**Name:** {{ $lead->name ?: '—' }}  
**Email:** {{ $lead->email }}  
**Phone:** {{ $lead->phone ?: '—' }}  
**Organisation:** {{ $lead->company ?: '—' }}  
**Country:** {{ $country }}  
**Page:** {{ $lead->page_url ?: '—' }}  
**Submitted:** {{ optional($lead->created_at)->timezone(config('app.timezone'))->format('d M Y, H:i') ?: now()->format('d M Y, H:i') }}
</x-mail::panel>

@if(filled($lead->message))
**Message**

{{ $lead->message }}
@else
**Message**

No message was included.
@endif

<x-mail::button :url="url('/admin/leads/'.$lead->getKey())">
View request in CMS
</x-mail::button>

You can reply directly to this email to reach the visitor.

Thanks,<br>
BYP Health website
</x-mail::message>
