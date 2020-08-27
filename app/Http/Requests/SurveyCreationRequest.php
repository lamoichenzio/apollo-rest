<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SurveyCreationRequest extends FormRequest
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
            'name' => 'required|string',
            'secret' => 'boolean',
            'active' => 'boolean',
            'start_date' => 'date|after:today',
            'end_date' => 'date|after:start_date',
            'icon' => 'sometimes|required',
            'icon.name' => 'required_with:icon|string',
            'icon.data' => 'required_with:icon|base64image|base64max:5000',
            'url_id' => 'required_if:active,true|url'
        ];
    }
}
