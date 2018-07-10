<?php

namespace App\Http\Requests\Cabinet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
  /*
  protected $user;
  public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
  {
      parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
      $this->user = Auth::user();
  }
  /**/
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
            'last_name' => 'required|string|max:255',
            /*'email' => 'required|string|email|max:255|unique:users,id,' . $this->user->id,/**/
            /*'phone' => 'required|string|max:255|regex:/^\d+$/s|unique:users,id,' . $this->user->id,/**/
            'phone' => 'required|string|max:255|regex:/^\d+$/s',
        ];
    }
}
