<?php

namespace App\Http\Resources\questions;

use App\Http\Resources\ImageFileResource;
use App\ImageFile;
use App\MatrixQuestion;
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
        $image = null;
        if ($this->icon) $image = ImageFileResource::make(ImageFile::find($this->icon));
        return [
            'id' => $this->id,
            'title' => $this->title,
            'position' => $this->position,
            'mandatory' => $this->mandatory,
            'icon' => $image,
            'questionType' => MatrixQuestion::class,
            'type' => $this->type,
            'elements' => $this->elements->map(function ($element) {
                return [
                    "id" => $element->id,
                    "title" => $element->title
                ];
            }),
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
