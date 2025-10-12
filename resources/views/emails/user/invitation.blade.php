@component('mail::message')
# Hello {{ $user->name }},

You’ve been invited to join **{{ config('app.name') }}**.

Click below to create your login credentials:

@component('mail::button', ['url' => $invitationLink])
Create Your Account
@endcomponent

If you didn’t expect this invitation, you can ignore this email.

Thanks,  
{{ config('app.name') }}
@endcomponent
