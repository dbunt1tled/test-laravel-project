@extends('layouts.admin')
@section('content')
    @include('admin.users._nv')
    <div class="d-flex flex-row mb-3">
        <a href="{{route('admin.users.edit',$user)}}" class="btn btn-primary mr-1">Редактировать</a>
        <form method="POST" action="{{route('admin.users.destroy',$user)}}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Удалить</button>
        </form>
        @if(!$user->isActive())
            <form method="POST" action="{{route('admin.users.verify',$user)}}" class="mr-1">
                @csrf
                <button class="btn btn-warning">Активировать</button>
            </form>
        @endif
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Просмотр пользователя: {{$user->name}}</div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Параметр</th>
                                <th>Значение</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>ID</td><td>{{$user->id}}</td></tr>
                            <tr><td>Имя</td> <td><a href="{{route('admin.users.edit',$user)}}">{{$user->name}}</a></td></tr>
                            <tr><td>Email</td><td>{{$user->email}}</td></tr>
                            <tr><td>Статус</td><td><span class="badge badge-{{$statuses[$user->status]['class']}}">{{$statuses[$user->status]['text']}}</span></td></tr>
                            <tr><td>Роль</td><td><span class="badge badge-{{$roles[$user->role]['class']}}">{{$roles[$user->role]['text']}}</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
