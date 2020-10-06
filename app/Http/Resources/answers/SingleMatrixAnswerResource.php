<?php

namespace App\Http\Resources\answers;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleMatrixAnswerResource extends JsonResource
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
            'answerPair' => $this->pairs->map(function ($pair) {
                return ['element' => $pair->element->title,
                    'answer' => $pair->answer];
            })
        ];
    }
}
