<?php

namespace App\Http\Resources\answers;

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
        return [
            'email' => $this->email,
            'totAnswers' => $this->totAnswers,
            'inputQuestionAnswers' => $this->inputQuestionAnswers->map(function ($answer) {
                return $answer->path();
            }),
//            'singleChoiceMultiAnswers',
//            'multiChoiceMultiAnswers',
//            'singleChoiceMatrixAnswers',
//            'multiChoiceMatrixAnswers',
            'survey' => $this->survey->path()
        ];
    }
}
