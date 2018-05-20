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
                    <form action="?" method="GET">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Статус</th>
                                    <th>Роль</th>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="id" id="id" value="{{request('id')}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" id="name" value="{{request('name')}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="email" id="email" value="{{request('email')}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="status" id="status">
                                                <option value="" ></option>
                                                @foreach($statuses as $value => $data)
                                                    <option value="{{$value}}" @if(is_numeric(request('status')) && $value == request('status')) selected @endif >{{$data['text']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="role" id="role">
                                                <option value="" ></option>
                                                @foreach($roles as $value => $data)
                                                    <option value="{{$value}}" @if($value == request('role')) selected @endif >{{$data['text']}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-success">Поиск</button>
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td><a href="{{route('admin.users.show',$user)}}">{{$user->name}}</a></td>
                                        <td>{{$user->email}}</td>
                                        <td><span class="badge badge-{{$statuses[$user->status]['class']}}">{{$statuses[$user->status]['text']}}</span></td>
                                        <td><span class="badge badge-{{$roles[$user->role]['class']}}">{{$roles[$user->role]['text']}}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
