@extends('layouts.admin')
@section('content')
    @include('admin.users._nv')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Создать пользователя:</div>
                <div class="card-body">

                    <form method="POST" action="{{route('admin.users.store')}}">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label">Имя</label>
                            <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control{{$errors->has('name')?' is-invalid':''}}" required />
                            @if($errors->has('name'))
                                <span class="invalid-feedback"><strong>{{$errors->first('name')}}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="text" id="email" name="email" value="{{old('email')}}" class="form-control{{$errors->has('email')?' is-invalid':''}}" required />
                            @if($errors->has('email'))
                                <span class="invalid-feedback"><strong>{{$errors->first('email')}}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label">Пароль</label>
                            <input type="password" id="password" name="password" value="{{old('password')}}" class="form-control{{$errors->has('password')?' is-invalid':''}}" required />
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
