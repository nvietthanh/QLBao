<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('accounts')->user()->hasRole('Creator');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'string|nullable',
            'image' => 'required',
            'content' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'max' => 'Trường :attribute có tối đa :max ký tự'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tiêu đề',
            'description' => 'mô tả',
            'image' => 'hình ảnh',
            'content' => 'nội dung'
        ];
    }
}
