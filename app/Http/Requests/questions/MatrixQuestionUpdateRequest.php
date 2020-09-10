<?php

namespace App\Http\Requests\questions;

use App\Enums\MatrixQuestionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MatrixQuestionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $matrixQuestion = $this->route('matrixQuestion');
        return $this->user()->can('update', $matrixQuestion);
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
            'type' => 'sometimes|required|' . Rule::in(MatrixQuestionTypes::types()),
            'position' => 'sometimes|required|numeric',
            'options' => 'sometimes|required|array|min:2',
            'elements' => 'sometimes|required|array|min:2'
        ];
    }
}
