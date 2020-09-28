<?php

namespace App\Http\Resources\questions;

use App\MultiQuestion;
use App\Services\ImageFileService;
use Illuminate\Http\Resources\Json\JsonResource;

class MultiQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $icon = ImageFileService::getImageFilePath($this->icon);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'position' => $this->position,
            'mandatory' => $this->mandatory,
            'icon' => $icon,
            'questionType' => MultiQuestion::class,
            'type' => $this->type,
            'other' => $this->other,
            'options' => $this->options->map(function ($option) {
                return [
                    "id" => $option->id,
                    "value" => $option->option
                ];
            }),
            'questionGroup' => $this->questionGroup->path(),
            'survey' => $this->questionGroup->survey->path()
        ];
    }
}
