<!-- Hello {{$user->name}}
Thank you for creating an account with us. Please, verify your email using the link:
{{route('verify',$user->verification_token)}} -->

@component('mail::message')
# Hello, {{$user->name}}

Thank you for creating an account with us. Please, verify your email using the link:

@component('mail::button', ['url' => route('verify',$user->verification_token)])
Confirm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
