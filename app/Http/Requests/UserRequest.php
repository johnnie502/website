<?php

namespace App\Http\Requests;

class UserRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    // CREATE ROLES
                    'username' => 'bail|required|min:3|max:20|unique:users',
                    'email' => 'sometimes|bail|required|email|min:5|max:30|unique:users',
                    'password' => 'bail|required|min:8|max:50|case_diff|numbers|letters|symbols|confirmed',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
                    'username' => 'bail|required|min:3|max:20|unique:users',
                    'email' => 'sometimes|bail|required|email|min:5|max:30|unique:users',
                    'password' => 'bail|required|min:8|max:50|case_diff|numbers|letters|symbols',
                    'g-recaptcha-response' => 'sometimes|required|recaptcha',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
