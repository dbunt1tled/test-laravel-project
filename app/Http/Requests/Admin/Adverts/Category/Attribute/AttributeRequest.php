<?php

namespace App\Http\Requests\Admin\Adverts\Category\Attribute;

use App\Entity\Adverts\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttributeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => ['required','string','max:255', Rule::in(array_keys(Attribute::typeList()))],
            'required' =>'nullable|string|max:255',
            'variants' =>'nullable|string',
            'sort' => 'required|integer',
        ];
    }
}
