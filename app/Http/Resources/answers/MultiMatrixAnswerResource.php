<?php

namespace App\Http\Resources\answers;

use Illuminate\Http\Resources\Json\JsonResource;

class MultiMatrixAnswerResource extends JsonResource
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
            'question' => $this->matrixQuestion->path(),
            'answersPair' => $this->answers->map(function ($pair) {
                return [
                    'element' => $pair->element->title,
                    'answers' => $pair->answers->map(function ($answer) {
                        return $answer->answer;
                    })];
            })
        ];
    }
}
