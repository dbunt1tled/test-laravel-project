@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Введите проверочный код</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cabinet.profile.phone') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="token" class="col-form-label">Код</label>
                            <input type="text" id="token" class="form-control{{ $errors->has('token') ? ' is-invalid' : '' }}" name="token" value="{{ old('token') }}" required>
                            @if ($errors->has('token'))
                                <span class="invalid-feedback"><strong>{{ $errors->first('token') }}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Отправить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection