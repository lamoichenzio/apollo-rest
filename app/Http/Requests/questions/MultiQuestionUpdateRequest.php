<?php

namespace App\Http\Requests\questions;

use App\Enums\MultiQuestionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MultiQuestionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $multiQuestion = $this->route('question');
        return $this->user()->can('update', $multiQuestion);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required|max:255',
            'mandatory' => 'boolean',
            'icon' => 'sometimes|required',
            'icon.name' => 'sometimes|required_with:icon|required_unless:icon,delete|string',
            'icon.data' => 'sometimes|required_with:icon|required_unless:icon,delete|base64image|base64max:5000',
            'type' => 'sometimes|required|' . Rule::in(MultiQuestionTypes::types()),
            'position' => 'sometimes|required|numeric',
            'other' => 'boolean',
            'options' => 'sometimes|required|array|size|min:2'
        ];
    }
}
