<?php

namespace App\Http\Requests;

class WikiRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    // CREATE ROLES
                    'title' => 'bail|required|min:3|max:20|unique:wikis',
                    'categroies' => 'bail|required',
                    'content' => 'bail|required|min:10',
                    'redirect' => 'exists:wikis,title',
                    'template' =>  'exists:wikis,title,type,3'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
                    'title' => 'bail|required|min:3|max:20|unique:wikis',
                    'categroies' => 'bail|required',
                    'content' => 'bail|required|min:10',
                    'redirect' => 'exists:wikis,title',
                    'template' =>  'exists:wikis,title,type,3',
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
