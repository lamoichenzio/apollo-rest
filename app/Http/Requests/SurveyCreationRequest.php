<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
            'startDate' => 'date|after:' . Carbon::now()->format('YY-MM-DD'),
            'endDate' => 'date|after:startDate',
            'icon' => 'sometimes|required',
            'icon.name' => 'required_with:icon|string',
            'icon.data' => 'required_with:icon|base64image|base64max:5000'
        ];
    }
}
