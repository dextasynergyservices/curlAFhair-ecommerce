@props(['url'])
@php
    $logoUrl = rtrim(config('app.url'), '/') . '/images/logo.png';
@endphp
<tr>
<td class="header">
    <a href="{{ $url }}" style="display: inline-block;">
        <img src="{{ $logoUrl }}" alt="CurlAFHair" width="180" style="max-width: 100%; height: auto;">
    </a>
</td>
</tr>

