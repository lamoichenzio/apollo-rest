<?php

namespace App\Http\Requests;

use App\InvitationPool;
use Illuminate\Foundation\Http\FormRequest;

class InvitationPoolCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', InvitationPool::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string',
            'emails' => 'required|array',
            'emails.*' => 'required|email|distinct'
        ];
    }
}
