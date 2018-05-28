@extends('layouts.admin')
@section('content')
    @include('admin.adverts.category._nv')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Редактировать аттрибут:</div>
                <div class="card-body">

                    <form method="POST" action="{{route('admin.adverts.category.attribute.update',[$category,$attribute])}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="col-form-label">Имя</label>
                            <input type="text" id="name" name="name" value="{{old('name', $attribute->name)}}" class="form-control{{$errors->has('name')?' is-invalid':''}}" required />
                            @if($errors->has('name'))
                                <span class="invalid-feedback"><strong>{{$errors->first('name')}}</strong></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="sort" class="col-form-label">Сортировка</label>
                            <input type="text" id="sort" name="sort" value="{{old('sort', $attribute->sort)}}" class="form-control{{$errors->has('sort')?' is-invalid':''}}" />
                            @if($errors->has('sort'))
                                <span class="invalid-feedback"><strong>{{$errors->first('sort')}}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="parent_id" class="col-form-label">Тип</label>
                            <select name="type" id="type"  class="form-control{{$errors->has('type')?' is-invalid':''}}">
                                @foreach($types as $type => $label)
                                    <option value="{{$type}}"  @if($type == old('type', $attribute->type)) selected @endif  >{{$label}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <span class="invalid-feedback"><strong>{{$errors->first('type')}}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="variants" class="col-form-label">Варианты</label>
                            <textarea id="variants" name="variants" class="form-control{{$errors->has('sort')?' is-invalid':''}}" >{{old('variants', implode("\n", $attribute->variants))}}</textarea>
                            @if($errors->has('variants'))
                                <span class="invalid-feedback"><strong>{{$errors->first('variants')}}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="required" value="0">
                            <label>
                                <input type="checkbox" name="required" id="required" {{old('required', $attribute->required)?'checked':''}} /> Обязательное
                            </label>
                            @if($errors->has('required'))
                                <span class="invalid-feedback"><strong>{{$errors->first('required')}}</strong></span>
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
