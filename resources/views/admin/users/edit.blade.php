@extends('layouts.admin')
@section('content')
    @include('admin.users._nv')
    <div class="d-flex flex-row mb-3">
        @can('users.manage')
            <form method="POST" action="{{route('admin.users.destroy',$user)}}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        @endif
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
                <div class="card-header">Редактирование пользователя: {{$user->name}}</div>
                <div class="card-body">

                    <form method="POST" action="{{route('admin.users.update',$user)}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="col-form-label">Имя</label>
                            <input type="text" name="name" id="name" value="{{old('name',$user->name)}}" class="form-control{{$errors->has('name')?' is-invalid':''}}" required />
                            @if($errors->has('name'))
                                <span class="invalid-feedback"><strong>{{$errors->first('name')}}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="text" name="email" id="email" value="{{old('email',$user->email)}}" class="form-control{{$errors->has('email')?' is-invalid':''}}" required />
                            @if($errors->has('email'))
                                <span class="invalid-feedback"><strong>{{$errors->first('email')}}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-form-label">Статус</label>
                            @if(is_array($statuses) && count($statuses))
                                <select name="status" id="status"  class="form-control{{$errors->has('status')?' is-invalid':''}}">
                                    @foreach($statuses as $value => $data)
                                        <option value="{{$value}}"  @if($value == old('status',$user->status)) selected @endif  >{{$data['text']}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="role" class="col-form-label">Статус</label>
                            @if(is_array($roles) && count($roles))
                                <select name="role" id="role"  class="form-control{{$errors->has('role')?' is-invalid':''}}">
                                    @foreach($roles as $value => $data)
                                        <option value="{{$value}}"  @if($value == old('role',$user->role)) selected @endif  >{{$data['text']}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Пароль</label>
                            <input type="password" name="password" id="password" value="{{old('password')}}" class="form-control{{$errors->has('password')?' is-invalid':''}}" />
                            @if($errors->has('password'))
                                <span class="invalid-feedback"><strong>{{$errors->first('password')}}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
