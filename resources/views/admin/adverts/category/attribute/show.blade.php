@extends('layouts.admin')
@section('content')
    @include('admin.adverts.category._nv')
    <div class="d-flex flex-row mb-3">
        <a href="{{route('admin.adverts.category.attribute.edit',[$category,$attribute])}}" class="btn btn-primary mr-1">Редактировать</a>
        <form method="POST" action="{{route('admin.adverts.category.attribute.destroy',[$category,$attribute])}}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Удалить</button>
        </form>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Аттрибут {{$attribute->name}}
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Сортировка</th>
                            <th>Название</th>
                            <th>Тип</th>
                            <th>Обязательный</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$attribute->sort}}</td>
                            <td>
                                <a href="{{route('admin.adverts.category.attribute.edit',[$category,$attribute])}}">{{$attribute->name}}</a>
                            </td>
                            <td>{{$attribute->type}}</td>
                            <td>{{$attribute->required ? 'Да':''}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
