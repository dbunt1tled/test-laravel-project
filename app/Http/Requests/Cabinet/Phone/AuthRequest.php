<?php

namespace App\Http\Requests\Cabinet\Phone;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AuthRequest extends FormRequest
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
            'phoneAuthEnable' => 'required|integer|min:0|max:1',
        ];
    }
}
