<?php

namespace App\Http\Resources\questions;

use App\Enums\MatrixQuestionTypes;
use App\MatrixQuestion;
use App\Services\ImageFileService;
use Illuminate\Http\Resources\Json\JsonResource;

class MatrixQuestionResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'position' => $this->position,
            'mandatory' => $this->mandatory,
            'icon' => $icon,
            'questionType' => MatrixQuestion::class,
            'type' => MatrixQuestionTypes::types(),
            'questionElements' => $this->elements->map(function ($element) {
                return $element->title;
            }),
            'options' => $this->options->map(function ($option) {
                return $option->option;
            }),
            'questionGroup' => $this->questionGroup->path(),
            'survey' => $this->questionGroup->survey->path()
        ];
    }
}
