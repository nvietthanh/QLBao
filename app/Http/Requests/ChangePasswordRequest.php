<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('accounts')->user() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'min:8', 'max:20'],
            'new_password' => ['required', 'min:8', 'max:20'],
            'confirm_new_password' => ['required', 'min:8', 'max:20', 'same:new_password']
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'mật khẩu',
            'new_password' => 'mật khẩu mới',
            'confirm_new_password' => 'mật khẩu xác nhận',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'min' => 'Trường :attribute có tối thiểu :min ký tự',
            'max' => 'Trường :attribute có tối đã :min ký tự',
            'same' => 'Trường :attribute không đúng'
        ];
    }
}
