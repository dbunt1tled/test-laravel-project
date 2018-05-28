<?php

namespace App\Http\Requests\Admin\Region;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @property string $name
     * @property string $slug
     * @property int|null $parent
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
            'name' => 'required|string|max:255|unique:region,name,NULL,parent_id,id,'.($this->request->get('parent')?: 'NULL'),
            'slug' => 'nullable|string|max:255|unique:region,slug,NULL,parent_id,id,'.($this->request->get('parent')?: 'NULL'),
            'parent' =>'nullable|exists:region,id'
        ];
    }
}
