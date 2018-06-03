@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Введите проверочный код:</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login.phone') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="token" class="col-sm-4 col-form-label text-md-right">Код:</label>

                            <div class="col-md-6">
                                <input id="token" type="text" class="form-control{{ $errors->has('token') ? ' is-invalid' : '' }}" name="token" value="{{ old('token') }}" required autofocus>

                                @if ($errors->has('token'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('token') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Отправить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
