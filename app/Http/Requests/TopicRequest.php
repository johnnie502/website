<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    // CREATE ROLES
                    'node' => 'bail|required|integer',
                    'title' => 'bail|required|min:8|max:80',
                    'tags' => 'bail|required',
                    'content' => 'bail|required|min:5|max:20000',                    
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
                    'node' => 'sometiles|bail}required|integer',
                    'title' => 'bail|required|min:8|max:80',
                    'content' => 'bail|required|min:5|max:20000',
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
