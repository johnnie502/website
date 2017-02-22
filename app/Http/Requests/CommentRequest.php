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
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
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
