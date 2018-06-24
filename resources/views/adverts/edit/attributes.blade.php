@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">Характеристики</div>
        <div class="card-body pb-2">
            @foreach($advert->category->allAttributes() as $attribute)
                <div class="form-group">
                    <label for="attribute_{{ $attribute->id }}" class="col-form-label">{{ $attribute->name }}</label>
                    @if($attribute->isSelect())
                        <select id="attribute_{{ $attribute->id }}" class="form-control{{ $errors->has('attribute.'.$attribute->id)? 'is-invalid' : '' }}" name="attribute[{{$attribute->id}}]">
                            <option value=""></option>
                            @foreach($attribute->variants as $variant)
                                <option value="{{$variant}}" {{$variant == old('$attributes.'.$attribute->id)?'selected':''}}>{{ $variant }}</option>
                            @endforeach
                        </select>
                    @elseif($attribute->isNumber())
                        <input type="number" id="attribute_{{ $attribute->id }}" value="{{ old('$attribute.'.$attribute->id) }}" class="form-control{{ $errors->has('attribute.'.$attribute->id)? 'is-invalid' : '' }}" name="attribute[{{$attribute->id}}]">
                    @else
                        <input type="text" id="attribute_{{ $attribute->id }}" value="{{ old('attribute.'.$attribute->id) }}" class="form-control{{ $errors->has('attribute.'.$attribute->id)? 'is-invalid' : '' }}" name="attribute[{{$attribute->id}}]">
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
@endsection