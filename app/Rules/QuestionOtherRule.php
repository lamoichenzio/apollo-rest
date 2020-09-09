<?php

namespace App\Rules;

use App\Enums\MultiQuestionTypes;
use Illuminate\Contracts\Validation\Rule;

class QuestionOtherRule implements Rule
{
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
        if (request()->isMethod('post')) {
            return !(request('type') == MultiQuestionTypes::$SELECT && $value);
        }
        if (request()->isMethod('put')) {
            $question = request()->route('multiQuestion');
            return !(
                ($question->type == MultiQuestionTypes::$SELECT ||
                    request('type') == MultiQuestionTypes::$SELECT) && $value);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute must be false if question type is ' . MultiQuestionTypes::$SELECT;
    }
}
