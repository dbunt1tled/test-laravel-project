@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Создать объявление</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('cabinet.adverts.create.advert.store', [$category, $region]) }}">
                        @csrf
                        <div class="card mb-3">
                            <div class="card-header">Общие</div>
                            <div class="card-body pb-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title" class="col-form-label">Название</label>
                                            <input type="text" id="title" class="form-control {{ $errors->has('title')? 'is-invalid':'' }}" name="title" value="{{ old('title') }}" required>
                                            @if($errors->has('title'))
                                                <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price" class="col-form-label">Цена</label>
                                            <input type="number" id="price" class="form-control {{ $errors->has('price')? 'is-invalid':'' }}" name="price" value="{{ old('price') }}" required>
                                            @if($errors->has('price'))
                                                <span class="invalid-feedback"><strong>{{ $errors->first('price') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address" class="col-form-label">Адрес</label>

                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address', $region->getAddress()) }}" required>
                                                    @if ($errors->has('address'))
                                                        <span class="invalid-feedback"><strong>{{ $errors->first('address') }}</strong></span>
                                                    @endif
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="btn btn-primary btn-block location-button" data-target="#address"><span class="fa fa-location-arrow"></span></span>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="content" class="col-form-label">Текст объявления</label>
                                            <textarea id="content" class="form-control {{ $errors->has('content')? 'is-invalid':'' }}" rows="10" name="content" required>{{ old('content') }}</textarea>
                                            @if($errors->has('content'))
                                                <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">Характеристики</div>
                            <div class="card-body pb-2">
                                @foreach($category->allAttributes() as $attribute)
                                    <div class="form-group">
                                        <label for="attribute_{{ $attribute->id }}" class="col-form-label">{{ $attribute->name }}</label>
                                        @if($attribute->isSelect())
                                            <select id="attribute_{{ $attribute->id }}" class="form-control{{ $errors->has('attribute.'.$attribute->id)? 'is-invalid' : '' }}" name="attribute[{{$attribute->id}}]">
                                                <option value=""></option>
                                                @foreach($attribute->variants as $variant)
                                                    <option value="{{$variant}}" {{$variant == old('$attributes.'.$attribute->id,$advert->getValue($attribute->id))?'selected':''}}>{{ $variant }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($attribute->isNumber())
                                            <input type="number" id="attribute_{{ $attribute->id }}" value="{{ old('$attribute.'.$attribute->id,$advert->getValue($attribute->id)) }}" class="form-control{{ $errors->has('attribute.'.$attribute->id)? 'is-invalid' : '' }}" name="attribute[{{$attribute->id}}]">
                                        @else
                                            <input type="text" id="attribute_{{ $attribute->id }}" value="{{ old('attribute.'.$attribute->id,$advert->getValue($attribute->id)) }}" class="form-control{{ $errors->has('attribute.'.$attribute->id)? 'is-invalid' : '' }}" name="attribute[{{$attribute->id}}]">
                                        @endif
                                        @if($errors->has('attribute.'.$attribute->id))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('attribute.'.$attribute->id) }}</strong></span>
                                        @endif
                                        @if ($errors->has('parent'))
                                            <span class="invalid-feedback"><strong>{{ $errors->first('attribute.' . $attribute->id) }}</strong></span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
