<?php

namespace App\Http\Resources\questions;

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
            'title' => $this->title,
            'description' => $this->description,
            'position' => $this->position,
            'mandatory' => $this->mandatory,
            'icon' => $icon,
            'type' => $this->type,
            'other' => $this->other,
            'options' => $this->options
        ];
    }
}
