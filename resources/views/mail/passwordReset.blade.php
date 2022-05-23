@component('mail::message')
<h1>Hi, {{ $userName }}!</h1>

We found your password reset request.<br>
Please click this button bellow, it will redirect you to a password reset page.
 
@php
    $appUrl = config('app.url');
@endphp

@component('mail::button', ['url' => $appUrl.'response-password-reset/'.$token])
Reset Password
@endcomponent

Regards,<br>
{{ config('app.name') }}
@endcomponent