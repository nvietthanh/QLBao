<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResgisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:accounts'],
            'date_of_birth' => ['date', 'nullable'],
            'male' => ['integer', 'nullable'],
            'phone' => ['numeric', 'min:11', 'nullable'],
            'password' => ['required', 'min:8', 'max:20'],
            'confirm_password' => ['required', 'min:8', 'max:20', 'same:password'],            
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường này là bắt buộc',
            'email.email' => 'Trường này phải là email',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'numeric' => 'Trường :attribute phải là số',
            'min' => 'Trường :attribute có tối thiểu :min ký tự',
            'max' => 'Trường :attribute có tối đa :max ký tự',
            'date' => 'Trường :attribute phải định dạng ngày tháng',
            'integer' => 'Trường :attribute phải là số nguyên',
            'same' => 'Trường :attribute không đúng'
        ];
    }

    public function attributes()
    {
        return [
            'phone' => 'số điện thoại',
            'date' => 'ngày sinh',
            'male' => 'giới tính',
            'password' => 'mật khẩu',
            'confirm_password' => 'xác nhận mật khẩu',
        ];
    }
}
