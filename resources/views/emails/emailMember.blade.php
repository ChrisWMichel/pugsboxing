@component('mail::message')


<h2>{{$contact['message']}}</h2>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
