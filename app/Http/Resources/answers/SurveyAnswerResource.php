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
            'id' => $this->id,
            'email' => $this->email,
            'totAnswers' => $this->totAnswers,
            'survey' => $this->survey->path(),
//            'inputAnswers' => SingleAnswerResource::collection($this->singleAnswers),
//            'multiAnswers' => MultiAnswerResource::collection($this->multiAnswers),
//            'singleMatrixAnswers' => SingleMatrixAnswerResource::collection($this->singleChoiceMatrixAnswers),
//            'multiMatrixAnswers' => MultiMatrixAnswerResource::collection($this->multiChoiceMatrixAnswers)
            'answers' => $this->answers()
        ];
    }
}
