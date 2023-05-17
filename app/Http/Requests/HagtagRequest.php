<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HagtagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Manager');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'tên hagtag'
        ];
    }
}
