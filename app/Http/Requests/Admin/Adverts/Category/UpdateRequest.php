<?php

namespace App\Http\Requests\Admin\Adverts\Category;

use App\Entity\Adverts\Category;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Category category
 */
class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'name' => 'required|string|max:255|unique:region,name,'.$this->category->id.',id,parent_id,'.$this->category->parent_id,
            'slug' => 'nullable|string|max:255|unique:region,slug,'.$this->category->id.',id,parent_id,'.$this->category->parent_id,
            'parent' =>'nullable|exists:region,id'
        ];
    }
}
