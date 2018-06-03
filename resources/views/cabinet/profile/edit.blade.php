@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Редактирование профиля</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cabinet.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name" class="col-form-label">Имя</label>
                            <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $user->name) }}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="col-form-label">Фамилия</label>
                            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('last_name') }}</strong></span>
                            @endif
                        </div>

                        {{--<div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input id="email" type="tel" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div> --}}

                        <div class="form-group">
                            <label for="phone" class="col-form-label">Телефон</label>
                            <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('phone') }}</strong></span>
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