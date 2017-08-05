@component('mail::message')
Hi {{$contact['firstname']}},

{!! $contact['message'] !!}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
