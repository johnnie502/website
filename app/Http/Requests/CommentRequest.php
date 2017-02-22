<?php

namespace App\Http\Requests;

class CommentRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    // CREATE ROLES
                    'content' => 'bail|required|min:10|max:20000',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
                    'content' => 'bail|required|min:10|max:20000',
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
