@component('mail::message')
# Изменение цены в объявлении {{ $this->advert->title }}
Уважаемый(ая) {{ $this->user->name }} {{ $this->user->last_name }},
цена в объявлении изменилась
старая цена - {{ $this->oldPrice }}
новая цена - {{ $this->advert->price }}
@component('mail::button', ['url' => route('adverts.show', $this->advert)])
Просмотреть
@endcomponent

Спасибо, <br>
компания {{ config('app.name') }}
@endcomponent