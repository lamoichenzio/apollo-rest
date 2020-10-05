<?php

namespace App\Http\Middleware;

use App\Enums\MatrixQuestionTypes;
use App\Enums\MultiQuestionTypes;
use App\InputQuestion;
use App\MatrixQuestion;
use App\MatrixQuestionElement;
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
            $questionType = $answer['questionType'];

            if ($questionType == InputQuestion::class || ($questionType == MultiQuestion::class
                    && key_exists('answer', $answer))) {
                $response = $this->singleAnswerValidator($survey, $answer);
                if (!$response['status']) {
                    return response()->json(['error' => $response['message']], 422);
                }
            }

            if ($questionType == MultiQuestion::class && key_exists('answers', $answer)) {
                $response = $this->multiAnswerValidator($survey, $answer);
                if (!$response['status']) {
                    return response()->json(['error' => $response['message']], 422);
                }
            }

            if ($questionType == MatrixQuestion::class && key_exists('answerPair', $answer)) {
                $response = $this->singleMatrixAnswerValidator($survey, $answer);
                if (!$response['status']) {
                    return response()->json(['error' => $response['message']], 422);
                }
            }

            if ($questionType == MatrixQuestion::class && key_exists('answersPair', $answer)) {
                $response = $this->multiMatrixAnswerValidator($survey, $answer);
                if (!$response['status']) {
                    return response()->json(['error' => $response['message']], 422);
                }
            }
        }
        return $next($request);
    }

    private function singleAnswerValidator($survey, $answer)
    {
        $question = null;
        $message = ['status' => true, 'message' => ""];
        if ($answer['questionType'] == InputQuestion::class) {
            $question = InputQuestion::find($answer['questionId']);
        }
        if ($answer['questionType'] == MultiQuestion::class) {
            $question = MultiQuestion::find($answer['questionId']);
        }
        if ($question == null) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $answer['questionId'] . ' of type ' . $answer['questionType'] . ' not found';
        } elseif ($question->questionGroup->survey->id != $survey->id) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $question->id . ' of type ' . $answer['questionType'] . ' not belonging to Survey';
        } elseif ((get_class($question) == MultiQuestion::class &&
                $question->type == MultiQuestionTypes::$CHECK) || !key_exists('answer', $answer)) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $question->id . ' of type ' . $answer['questionType'] . ' not coherent with answer field';
        }
        return $message;
    }

    private function multiAnswerValidator($survey, $answer)
    {
        $message = ['status' => true, 'message' => ''];
        $question = MultiQuestion::find($answer['questionId']);
        if (!$question) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $answer['questionId'] . ' of type ' . $answer['questionType'] . ' not found';
        } elseif ($question->questionGroup->survey->id != $survey->id) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $question->id . ' of type ' . $answer['questionType'] . ' not belonging to Survey';
        } elseif ($question->type != MultiQuestionTypes::$CHECK) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $question->id . ' of type ' . $answer['questionType'] . ' not coherent with answer field';
        }
        return $message;
    }

    private function singleMatrixAnswerValidator($survey, $answer)
    {
        $message = ['status' => true, 'message' => ''];
        $question = MatrixQuestion::find($answer['questionId']);
        if (!$question) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $answer['questionId'] . ' of type ' . $answer['questionType'] . ' not found';
        } elseif ($question->questionGroup->survey->id != $survey->id) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $question->id . ' of type ' . $answer['questionType'] . ' not belonging to Survey';
        } elseif ($question->type != MatrixQuestionTypes::$RADIO) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $question->id . ' of type ' . $answer['questionType'] . ' not coherent with answer field';
        } else {
            // VALIDATION OF MATRIX ELEMENTS
            foreach ($answer['answerPair'] as $pair) {
                $message = $this->matrixElementValidator($pair['element'], $question, $message);
            }
        }
        return $message;
    }

    private function matrixElementValidator($element_id, $question, $message)
    {
        $element = MatrixQuestionElement::find($element_id);
        if (!$element) {
            $message['status'] = false;
            $message['message'] = 'Matrix element ' . $element_id . ' of single matrix ' . $question->id . ' not found';
        } elseif ($element->matrixQuestion->id != $question->id) {
            $message['status'] = false;
            $message['message'] = 'Matrix element' . $element_id . ' not belonging to single matrix' . $question->id;
        }
        return $message;
    }

    private function multiMatrixAnswerValidator($survey, $answer)
    {
        $message = ['status' => true, 'message' => ''];
        $question = MatrixQuestion::find($answer['questionId']);
        if (!$question) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $answer['questionId'] . ' of type ' . $answer['questionType'] . ' not found';
        } elseif ($question->questionGroup->survey->id != $survey->id) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $question->id . ' of type ' . $answer['questionType'] . ' not belonging to Survey';
        } elseif ($question->type != MatrixQuestionTypes::$CHECK) {
            $message['status'] = false;
            $message['message'] = 'Question ' . $question->id . ' of type ' . $answer['questionType'] . ' not coherent with answer field';
        } else {
            // VALIDATION OF MATRIX ELEMENTS
            foreach ($answer['answersPair'] as $pair) {
                $message = $this->matrixElementValidator($pair['element'], $question, $message);
            }
        }
        return $message;
    }
}
