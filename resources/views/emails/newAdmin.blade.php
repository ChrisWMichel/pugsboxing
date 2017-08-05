@component('mail::message')


Hello {{$admin->firstname}}, you have been registered as an administrator for Pug's Boxing Gym.
Please click the link below to complete the registration.

<br>

{{route('verify', $admin->verification_code)}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
