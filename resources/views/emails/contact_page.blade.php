@component('mail::message')
<h1>{{$contact['firstname']}} sent you a message from the contact page of your website on {{$contact['date']}}.</h1>


<h2><span style="color: green;">From:</span> {{$contact['firstname']}}</h2>

<span style="color: green;">Email:</span> {{$contact['email']}}

<h2><span style="color: green;">Subject:</span> {{$contact['subject']}}</h2>

<h2><span style="color: green;">Message:</span> {{$contact['message']}}</h2>



@endcomponent
