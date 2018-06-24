@extends('layouts.app')
@section('breadcrumbs', '')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Объявления</div>

                <div class="card-body">
                    <p><a href="{{ route('cabinet.adverts.create') }}" class="btn btn-success">Создать объявление</a></p>
                    <div class="card card-default mb-3">
                        <div class="card-header">Все категории</div>

                        <div class="card-body pb-0">
                            <div class="row">
                                @foreach(array_chunk($categories, 3) as $chunk)
                                    <ul class="list-unstyled mr-3">
                                        @foreach($chunk as $current)
                                            <li><a href="{{ route('adverts.index',adverts_path(null, $current)) }}">{{ $current->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card card-default mb-3">
                        <div class="card-header">Все регионы</div>

                        <div class="card-body pb-0">
                            <div class="row">
                                @foreach(array_chunk($regions, 3) as $chunk)
                                    <ul class="list-unstyled mr-3">
                                        @foreach($chunk as $current)
                                            <li><a href="{{ route('adverts.index',adverts_path($current, null)) }}">{{ $current->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
