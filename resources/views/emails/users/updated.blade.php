@component('mail::message')
# Welcome To SmartEclipse

Dear {{$name}} your account details has been updated !!

User Name : {{$username}}

Password : {{$password}}

@component('mail::button', ['url' => $url])
Login 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
