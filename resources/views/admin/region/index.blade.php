@extends('layouts.admin')
@section('content')
    @include('admin.region._nv')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Список регионов</div>
                <div class="card-body">
                    <div class="d-flex flex-row mb-3">
                            <a href="{{route('admin.region.create')}}" class="btn btn-success mr-1">Создать</a>
                    </div>
                    @include('admin.region._list',['regions'=>$regions]);
                </div>
            </div>
        </div>
    </div>
@endsection
