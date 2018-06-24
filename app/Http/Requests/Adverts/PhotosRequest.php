<?php

namespace App\Http\Requests\Adverts;

use Illuminate\Foundation\Http\FormRequest;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use Illuminate\Validation\Rule;

/**
 * @property array $files
 */

class PhotosRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'files.*' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
}
