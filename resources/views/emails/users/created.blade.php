@component('mail::message')
# Welcome To SmartEclipse

Dear {{$name}} your account has been created !!

User Name : {{$username}}

Password : {{$password}}

@component('mail::button', ['url' => $url])
Login 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
