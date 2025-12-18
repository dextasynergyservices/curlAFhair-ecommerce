@component('mail::message')
# Here is your promo code!

Thanks for signing up! Here is your exclusive promo code:

@component('mail::panel')
{{ $promoCode }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
