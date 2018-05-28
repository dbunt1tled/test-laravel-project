@extends('layouts.admin')
@section('content')
    @include('admin.region._nv')
    <div class="d-flex flex-row mb-3">
        <a href="{{route('admin.region.edit',$region)}}" class="btn btn-primary mr-1">Редактировать</a>
        <form method="POST" action="{{route('admin.region.destroy',$region)}}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Удалить</button>
        </form>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Просмотр региона: {{$region->name}}</div>
                <div class="card-body">
                    <div class="d-flex flex-row mb-3">
                        <a href="{{route('admin.region.create',['parent' => $region->id])}}" class="btn btn-success mr-1">Создать подрегион</a>
                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Параметр</th>
                                <th>Значение</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>ID</td><td>{{$region->id}}</td></tr>
                            <tr><td>Имя</td> <td><a href="{{route('admin.region.edit',$region)}}">{{$region->name}}</a></td></tr>
                            <tr><td>Сео Урл</td><td>{{$region->slug}}</td></tr>
                            @if($region->parent)
                                <tr><td>Родительский регион</td><td><a href="{{route('admin.region.show',$region->parent)}}">{{$region->parent->name}}</a></td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Подчиненные регионы
                </div>
                <div class="card-body">
                    @include('admin.region._list',['regions'=>$regions])
                </div>
            </div>
        </div>
    </div>
@endsection
