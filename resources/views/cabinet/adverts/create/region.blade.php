@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Выберите регион</div>

                <div class="card-body">
                    @if($region)
                        <p>
                            <a href="{{ route('cabinet.adverts.create.advert',[$category,$region]) }}" class="btn btn-success">Добавить Объявление для {{ $region->name }}</a>
                        </p>
                    @else
                        <p>
                            <a href="{{ route('cabinet.adverts.create.advert',[$category]) }}" class="btn btn-success">Добавить Объявление для всех регионов</a>
                        </p>
                    @endif
                    <p>Или выберете вложенный регион</p>
                    <ul>
                        @foreach($regions as $current)
                            <li>
                                <a href="{{ route('cabinet.adverts.create.advert',[$category,$current]) }}" class="btn btn-success">Добавить Объявление для {{ $current->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
