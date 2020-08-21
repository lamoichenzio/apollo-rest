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
            'pic' => 'sometimes|required',
            'pic.name' => 'required_with:pic|string',
            'pic.data' => 'required_with:pic|base64image|base64max:5000'
        ];
    }
}
