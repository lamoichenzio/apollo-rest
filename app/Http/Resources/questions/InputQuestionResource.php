<?php

namespace App\Http\Resources\questions;

use App\Http\Resources\ImageFileResource;
use App\ImageFile;
use App\InputQuestion;
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
        $image = null;
        if ($this->icon) $image = ImageFileResource::make(ImageFile::find($this->icon));
        return [
            'id' => $this->id,
            'title' => $this->title,
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
