<?php

namespace App\Http\Middleware;

use App\Enums\MultiQuestionTypes;
use App\InputQuestion;
use App\MultiQuestion;
use Closure;

class AnswerValidator
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $survey = $request->route('survey');
        if (!$survey->active) {
            return response()->json(['error' => 'The survey is not active'], 422);
        }
        foreach ($request['answers'] as $answer) {
            $question_type = $answer['question_type'];
            if ($question_type == InputQuestion::class || ($question_type == MultiQuestion::class
                    && key_exists('answer', $answer))) {
                $response = $this->singleAnswerValidator($survey, $answer);
                if (!$response['status']) {
                    return response()->json(['error' => $response['message']], 422);
                }
            }
            // TODO validare multi questions

            // TODO validare matrix questions
        }
        return $next($request);
    }

    private function singleAnswerValidator($survey, $answer)
    {
        $question = null;
        $message = ['status' => true, 'message' => ""];
        if ($answer['question_type'] == InputQuestion::class) {
            $question = InputQuestion::find($answer['question_id']);
        }
        if ($answer['question_type'] == MultiQuestion::class) {
            $question = MultiQuestion::find($answer['question_id']);
        }
        if ($question == null) {
            $message['status'] = false;
            $message['message'] = 'Question not found';
        } elseif ($question->questionGroup->survey->id != $survey->id) {
            $message['status'] = false;
            $message['message'] = 'Question not belonging to Survey';
            return $message;
        } elseif (get_class($question) == MultiQuestion::class && $question->type == MultiQuestionTypes::$CHECK) {
            $message['status'] = false;
            $message['message'] = 'Question type not coherent with answer field';
            return $message;
        }
        return $message;
    }
}
