@extends('layouts.admin')
@section('content')
    @include('admin.adverts.category._nv')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Список регионов</div>
                <div class="card-body">
                    <div class="d-flex flex-row mb-3">
                            <a href="{{route('admin.adverts.category.create')}}" class="btn btn-success mr-1">Создать</a>
                    </div>
                    @include('admin.adverts.category._list',['categories'=>$categories]);
                </div>
            </div>
        </div>
    </div>
@endsection
