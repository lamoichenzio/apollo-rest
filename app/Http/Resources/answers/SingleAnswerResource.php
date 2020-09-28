<?php

namespace App\Http\Resources\answers;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleAnswerResource extends JsonResource
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
            'question' => $this->question->path(),
            'answer' => $this->answer,
        ];
    }
}
