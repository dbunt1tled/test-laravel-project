<?php
namespace App\Http\Requests\Banner;
use Illuminate\Foundation\Http\FormRequest;
class RejectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'reason' => 'required|string',
        ];
    }
}