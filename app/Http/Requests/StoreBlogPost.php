<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreBlogPost extends FormRequest
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
            'user_name' => [
                'required',
                'max:30',
                'unique:user',
                'min:3',
                'regex:/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]+$/u',
                 Rule::unique('user')->ignore(request()->user_id,'user_id')
            ],
            'user_age' => 'required',
        ];
    }
    public function messages(){
        return [
            'user_name.required' => '用户名必填',
            'user_name.unique' => '用户名已存在',
            'user_name.max'=>'用户名最大长度30位',
            'user_name.min'=>'用户名最小长度3位',
            'user_name.regex'=>'用户名格式为字母数字下划线',
            'user_age.required' => '年龄必填',
          
        ];
    }
}
