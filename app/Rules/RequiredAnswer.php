<?php

namespace App\Rules;

use App\Enums\MatrixQuestionTypes;
use App\Enums\MultiQuestionTypes;
use App\InputQuestion;
use App\MatrixQuestion;
use App\MultiQuestion;
use Illuminate\Contracts\Validation\Rule;

class RequiredAnswer implements Rule
{
    private $answer;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $answer) {
            $this->answer = $answer;
            if ($answer['question_type'] == InputQuestion::class && !key_exists('answer', $answer)) {
                return false;
            }
            if ($answer['question_type'] == MultiQuestion::class) {
                $question = MultiQuestion::find($answer['question_id']);
                if ($question && $question->type != MultiQuestionTypes::$CHECK && !key_exists('answer', $answer)) {
                    return false;
                } elseif ($question && $question->type == MultiQuestionTypes::$CHECK && !key_exists('answers', $answer)) {
                    return false;
                }
            }
            if ($answer['question_type'] == MatrixQuestion::class) {
                $question = MatrixQuestion::find($answer['question_id']);
                if ($question && $question->type == MatrixQuestionTypes::$RADIO && !key_exists('answer_pair', $answer)) {
                    return false;
                }
                if ($question && $question->type == MatrixQuestionTypes::$CHECK && !key_exists('answers_pair', $answer)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Question ' . $this->answer['question_id'] . ' of type ' . $this->answer['question_type'] . ' not coherent with answer field';
    }
}
