@component('mail::message')
Hello {{ $user->name }} {{ $user->l_name }}


{!! $user->message !!}

Thanks ,<br>
{{ config('app.name') }}


@endcomponent
