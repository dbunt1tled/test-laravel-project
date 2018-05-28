@extends('layouts.admin')
@section('content')
    @include('admin.adverts.category._nv')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Создать регион:</div>
                <div class="card-body">

                    <form method="POST" action="{{route('admin.adverts.category.store')}}">
                        @csrf
                        <input type="hidden" name="parent" value="@if($parent){{$parent->id}}@endif" />
                        <div class="form-group">
                            <label for="name" class="col-form-label">Имя</label>
                            <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control{{$errors->has('name')?' is-invalid':''}}" required />
                            @if($errors->has('name'))
                                <span class="invalid-feedback"><strong>{{$errors->first('name')}}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="slug" class="col-form-label">Сео Урл</label>
                            <input type="text" id="slug" name="slug" value="{{old('slug')}}" class="form-control{{$errors->has('slug')?' is-invalid':''}}" />
                            @if($errors->has('slug'))
                                <span class="invalid-feedback"><strong>{{$errors->first('slug')}}</strong></span>
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
