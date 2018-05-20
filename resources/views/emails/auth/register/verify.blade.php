@component('mail::message')
# Подтверждение регистрации
Пожалуйста перейдите по следующей ссылки для подтверждения Вашего электронного ящика:

@component('mail::button', ['url' => route('register.verify', ['token' => $user->verify_token])])
Подтверждение Email
@endcomponent

Спасибо, <br>
компания {{ config('app.name') }}
@endcomponent