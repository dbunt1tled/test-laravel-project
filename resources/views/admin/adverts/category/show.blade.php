@extends('layouts.admin')
@section('content')
    @include('admin.adverts.category._nv')
    <div class="d-flex flex-row mb-3">
        <a href="{{route('admin.adverts.category.edit',$category)}}" class="btn btn-primary mr-1">Редактировать</a>
        <form method="POST" action="{{route('admin.adverts.category.destroy',$category)}}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Удалить</button>
        </form>
        <a href="{{ route('admin.adverts.category.attribute.create', $category) }}" class="btn btn-success">Добавить
                                                                                                            аттрибут</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Просмотр категории: {{$category->name}}</div>
                <div class="card-body">
                    <div class="d-flex flex-row mb-3">
                        <a href="{{route('admin.adverts.category.create',['parent' => $category->id])}}" class="btn btn-success mr-1">Создать
                                                                                                                                      подкатегорию</a>
                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Параметр</th>
                            <th>Значение</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>ID</td>
                            <td>{{$category->id}}</td>
                        </tr>
                        <tr>
                            <td>Имя</td>
                            <td><a href="{{route('admin.adverts.category.edit',$category)}}">{{$category->name}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Сео Урл</td>
                            <td>{{$category->slug}}</td>
                        </tr>
                        @if($category->parent)
                            <tr>
                                <td>Родительский регион</td>
                                <td>
                                    <a href="{{route('admin.adverts.category.show',$category->parent)}}">{{$category->parent->name}}</a>
                                </td>
                            </tr>
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
                    Аттрибуты
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
                            <td colspan="4">Родительские аттрибуты</td>
                        </tr>
                        @forelse($parentAttributes as $attribute)
                            <tr>
                                <td>{{$attribute->sort}}</td>
                                <td>{{$attribute->name}}</td>
                                <td>{{$attribute->type}}</td>
                                <td>{{$attribute->required ? 'Да':''}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="4">Свои аттрибуты</td>
                        </tr>
                        @forelse($attributes as $attribute)
                            <tr>
                                <td>{{$attribute->sort}}</td>
                                <td>
                                    <a href="{{route('admin.adverts.category.attribute.show',[$category,$attribute])}}">{{$attribute->name}}</a>
                                </td>
                                <td>{{$attribute->type}}</td>
                                <td>{{$attribute->required ? 'Да':''}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                        @endforelse
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
                    Подчиненные категории
                </div>
                <div class="card-body">
                    @include('admin.adverts.category._list',['categories'=>$categories])
                </div>
            </div>
        </div>
    </div>
@endsection
