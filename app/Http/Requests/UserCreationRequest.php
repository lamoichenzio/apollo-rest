<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreationRequest extends FormRequest
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
            'username' => 'required|string|min:4',
            'password' => 'required|string|min:5',
            'email' => 'required|email|string|unique:mysql.users',
            'file' => 'sometimes|required',
            'file.name' => 'required_with:file|string',
            'file.data' => 'required_with:file|image'
        ];
    }
}
