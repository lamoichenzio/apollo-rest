<?php

namespace App\Http\Requests\questions;

use App\Enums\MatrixQuestionTypes;
use App\MatrixQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MatrixQuestionCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', MatrixQuestion::class);
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
            'type' => 'required|' . Rule::in(MatrixQuestionTypes::types()),
            'position' => 'required|numeric',
            'options' => 'required|array|min:2',
            'elements' => 'required|array|min:2'
        ];
    }
}
