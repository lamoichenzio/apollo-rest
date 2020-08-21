<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->route('user');
        return $user && $this->user()->can('update', $user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'sometimes|required|min:4',
            'password' => 'sometimes|required|min:5',
            'old_password' => 'required_with:password|password',
            'email' => 'sometimes|required|email|unique:users',
            'avatar' => 'sometimes|required',
            'avatar.name' => 'sometimes|required_with:avatar|required_unless:avatar,delete|string',
            'avatar.data' => 'sometimes|required_with:avatar|required_unless:avatar,delete|base64image|base64max:5000'
        ];
    }
}
