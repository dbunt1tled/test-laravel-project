<?php

namespace App\Http\Requests\Admin\Users;

use App\Entity\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property User $user
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,id,' . $this->user->id,
            'status' => ['required','string',Rule::in(array_keys(User::getStatuses()))],
            'role' => ['required','string',Rule::in(array_keys(User::rolesList()))],
            'password' => 'sometimes|nullable|min:6',
        ];
    }
}
