@component('mail::message')
# New Promo Registration

A new user just registered for the promo. Here are the details:

- **Name:** {{ $promo->name }}
- **Email:** {{ $promo->email }}
- **Phone:** {{ $promo->phone }}
- **Promo Code:** {{ $promo->promo_code }}
- **Wants Newsletter:** {{ $promo->wants_newsletter ? 'Yes' : 'No' }}
- **Registered At:** {{ optional($promo->created_at)->format('M d, Y H:i') ?? 'N/A' }}

@component('mail::button', ['url' => config('app.url/login')])
Open Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

