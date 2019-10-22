<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize ()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules ()
    {
        return [
            'name'        => 'required|string|between:6,50',
            'description' => 'required|max:20000',
            'code'        => 'required|max:50000',
            'publish'     => 'boolean',
        ];
    }
}
