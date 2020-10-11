<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SurveyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $survey = $this->route('survey');
        return $survey && $this->user()->can('update', $survey);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string',
            'secret' => 'boolean',
            'startDate' => 'date|after:today',
            'endDate' => 'date|after:start_date',
            'active' => 'boolean',
            'icon' => 'sometimes|required',
            'icon.name' => 'sometimes|required_with:icon|required_unless:icon,delete|string',
            'icon.data' => 'sometimes|required_with:icon|required_unless:icon,delete|base64image|base64max:5000',
        ];
    }
}
