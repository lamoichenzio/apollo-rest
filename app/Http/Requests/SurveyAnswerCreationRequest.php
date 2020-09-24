<?php

namespace App\Http\Requests;

use App\InputQuestion;
use App\MatrixQuestion;
use App\MultiQuestion;
use App\Rules\RequiredAnswer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SurveyAnswerCreationRequest extends FormRequest
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
            'email' => 'email|' . Rule::requiredIf(function () {
                    $survey = request('survey');
                    return $survey->secret;
                }),
            'answers' => ['required', 'array', new RequiredAnswer()],
            'answers.*.question_id' => 'required',
            'answers.*.question_type' => 'required|' . Rule::in([
                    InputQuestion::class, MultiQuestion::class, MatrixQuestion::class]),
            'answers.*.answer' => [
                'string',
                'required_without_all:answers.*.answers,answers.*.answer_pair,answers.*.answers_pair'],
            'answers.*.answers' => 'array|required_without_all:answers.*.answer,answers.*.answer_pair,answers.*.answers_pair',
            'answers.*.answers.*' => 'sometimes|required|string',
            'answers.*.answer_pair' => 'string|required_without_all:answers.*.answers,answers.*.answer,answers.*.answers_pair',
            'answers.*.answers_pair' => 'string|required_without_all:answers.*.answers,answers.*.answer_pair,answers.*.answer',
        ];
    }
}
