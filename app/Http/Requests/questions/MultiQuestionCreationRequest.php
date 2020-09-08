<?php

namespace App\Http\Requests\questions;

use App\Enums\MultiQuestionTypes;
use App\MultiQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MultiQuestionCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', MultiQuestion::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'mandatory' => 'boolean',
            'icon' => 'sometimes|required',
            'icon.name' => 'required_with:icon|string',
            'icon.data' => 'required_with:icon|base64image|base64max:5000',
            'type' => 'required|' . Rule::in(MultiQuestionTypes::types()),
            'position' => 'required|numeric',
            'other' => 'boolean',
            'options' => 'required|array|size|min:2'
        ];
    }
}
