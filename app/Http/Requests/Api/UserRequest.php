<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\FormRequest;
use App\Rules\Phone;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            {
                return [
                    'id' => ['required, exists:users,id']
                ];
            }
            case 'POST':
            {
                return [
                    'name' => ['required', 'string', 'min:5', 'max:12', 'unique:users,name'],
                    'password' => ['required', 'confirmed', 'max:16', 'min:6'],
                    'username' => ['required', 'string', 'min:5', 'max:12', 'unique:users,username'],
                    'real_name' => ['string'],
                    'email' => ['email:rfc,dns', 'unique:users,email'],
                    'gender' => [
                        'required',
                        Rule::in(['male', 'female']),
                    ],
                    'phone' => [
                        'required',
                        'unique:users',
                        new Phone(),
                    ],
                ];
            }
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            default:
            {
                return [

                ];
            }
        }
    }

    public function messages()
    {
        return [
            'id.required'=>'用户ID必须填写',
            'id.exists'=>'用户不存在',
            'username.unique' => '用户名已经存在',
            'username.required' => '用户名不能为空',
            'username.max' => '用户名最大长度为12个字符',
            'password.required' => '密码不能为空',
            'password.max' => '密码长度不能超过16个字符',
            'password.min' => '密码长度不能小于6个字符'
        ];
    }

    public function attributes()
    {
        return [
            'phone' => '手机号',
            'gender' => '性别',
        ];
    }
}
