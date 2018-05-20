@extends('layouts.admin')
@section('content')
    @include('admin.users._nv')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Список пользователей</div>
                <div class="card-body">
                    <div class="d-flex flex-row mb-3">
                            <a href="{{route('admin.users.create')}}" class="btn btn-success mr-1">Создать</a>
                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td><a href="{{route('admin.users.show',$user)}}">{{$user->name}}</a></td>
                                    <td>{{$user->email}}</td>
                                    <td><span class="badge badge-{{$statuses[$user->status]['class']}}">{{$statuses[$user->status]['text']}}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
