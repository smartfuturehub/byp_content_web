@props(['url', 'logoSrc' => null])
@php
    $logoSrc = filled($logoSrc) ? $logoSrc : \App\Support\MailLogo::src();
@endphp
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;" target="_blank" rel="noopener noreferrer">
<img src="{{ $logoSrc }}" alt="BYP Health" class="logo" height="72" style="display: block; border: 0; outline: none; text-decoration: none; height: 72px; width: auto; max-width: 160px;">
</a>
</td>
</tr>
