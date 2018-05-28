@extends('layouts.admin')
@section('content')
    @include('admin.adverts.category._nv')
    <div class="d-flex flex-row mb-3">
        @can('adverts.category.manage')
            <form method="POST" action="{{route('admin.adverts.category.destroy',$category)}}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        @endif
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Редактирование региона: {{$category->name}}</div>
                <div class="card-body">

                    <form method="POST" action="{{route('admin.adverts.category.update',$category)}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="col-form-label">Имя</label>
                            <input type="text" name="name" id="name" value="{{old('name',$category->name)}}" class="form-control{{$errors->has('name')?' is-invalid':''}}" required />
                            @if($errors->has('name'))
                                <span class="invalid-feedback"><strong>{{$errors->first('name')}}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="slug" class="col-form-label">Сео Урл</label>
                            <input type="text" name="slug" id="slug" value="{{old('slug',$category->slug)}}" class="form-control{{$errors->has('slug')?' is-invalid':''}}" />
                            @if($errors->has('slug'))
                                <span class="invalid-feedback"><strong>{{$errors->first('slug')}}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="parent_id" class="col-form-label">Родительский регион</label>
                            @if(is_object($categories) && count($categories))
                                <select name="parent_id" id="parent_id"  class="form-control{{$errors->has('parent_id')?' is-invalid':''}}">
                                    <option value=""  @if(empty(old('parent_id',$category->parent_id))) selected @endif  >Верхний уровень</option>
                                    @foreach($categories as $value)
                                        <option value="{{$value->id}}"  @if($value->id == old('parent_id',$category->parent_id)) selected @endif  >@for($i = 0; $i <$value->depth; $i++) &mdash; @endfor{{$value->name}}</option>
                                    @endforeach
                                </select>
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
