<?php

namespace App\Http\Resources\questions;

use App\InputQuestion;
use App\Services\ImageFileService;
use Illuminate\Http\Resources\Json\JsonResource;

class InputQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $image = ImageFileService::getImageFilePath($this->icon);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'position' => $this->position,
            'mandatory' => $this->mandatory,
            'icon' => $image,
            'questionType' => InputQuestion::class,
            'type' => $this->type,
            'createDate' => $this->created_at,
            'questionGroup' => $this->questionGroup->path(),
            'survey' => $this->questionGroup->survey->path()
        ];
    }
}
