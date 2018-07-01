@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Управление</div>

                <div class="card-body">
                   <div class="region-selector" data-selected="{{json_encode((array) old('regions'))}}" data-source="{{route('ajax.regions')}}"></div>

                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item"><a class="nav-link active" href="{{ route('cabinet.home') }}">Управление</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('cabinet.adverts.index') }}">Объявления</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('cabinet.favorites.index') }}">Избранное</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('cabinet.banners.index') }}">Баннеры</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('cabinet.profile.home') }}">Профиль</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        console.log('continue');
    </script>
@endsection
