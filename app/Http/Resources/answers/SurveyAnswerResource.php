<?php

namespace App\Http\Resources\answers;

use App\Enums\MatrixQuestionTypes;
use App\Enums\MultiQuestionTypes;
use App\InputQuestion;
use App\MatrixQuestion;
use App\MultiQuestion;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $answers = $this->answers();

        //Filter questions by id
        if ($request->has('question_id') && $request->has('question_type')) {
            $questionId = $request['question_id'];
            if ($request['question_type'] == InputQuestion::class) {
                $answers = SingleAnswerResource::collection($this->singleAnswers->filter(
                    function ($singleAnswer) use ($questionId) {
                        return $singleAnswer->question_id == $questionId;
                    }
                ));
            }
            if ($request['question_type'] == MultiQuestion::class) {
                $question = MultiQuestion::find($questionId);
                if ($question->type != MultiQuestionTypes::$CHECK) {
                    $answers = SingleAnswerResource::collection($this->singleAnswers->filter(
                        function ($singleAnswer) use ($questionId) {
                            return $singleAnswer->question_id == $questionId;
                        }
                    ));
                } else {
                    $answers = MultiAnswerResource::collection($this->multiAnswers->filter(
                        function ($multiAnswer) use ($questionId) {
                            return $multiAnswer->multi_question_id == $questionId;
                        }
                    ));
                }
            }
            if ($request['question_type'] == MatrixQuestion::class) {
                $question = MatrixQuestion::find($questionId);
                if ($question->type == MatrixQuestionTypes::$RADIO) {
                    $answers = SingleMatrixAnswerResource::collection($this->singleChoiceMatrixAnswers->filter(
                        function ($singleMatrixAnswer) use ($questionId) {
                            return $singleMatrixAnswer->matrix_question_id == $questionId;
                        }
                    ));
                } else {
                    $answers = MultiMatrixAnswerResource::collection($this->multiChoiceMatrixAnswers->filter(
                        function ($multiMatrixAnswer) use ($questionId) {
                            return $multiMatrixAnswer->matrix_question_id == $questionId;
                        }
                    ));
                }
            }
        }

        return [
            'id' => $this->id,
            'email' => $this->email,
            'totAnswers' => $this->totAnswers,
            'survey' => $this->survey->path(),
            'createDate' => $this->created_at,
//            'inputAnswers' => SingleAnswerResource::collection($this->singleAnswers),
//            'multiAnswers' => MultiAnswerResource::collection($this->multiAnswers),
//            'singleMatrixAnswers' => SingleMatrixAnswerResource::collection($this->singleChoiceMatrixAnswers),
//            'multiMatrixAnswers' => MultiMatrixAnswerResource::collection($this->multiChoiceMatrixAnswers)
            'answers' => $answers,

        ];
    }
}
