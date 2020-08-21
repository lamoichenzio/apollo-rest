<?php

namespace App\Http\Resources;

use App\Services\ImageFileService;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $image,
            'secret' => $this->secret,
            'active' => $this->active,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'url_id' => $this->url_id,
            'user' => $this->user->path(),
            'question_groups' => $this->questionGroups->map(function ($questionGroup) {
                return $questionGroup->path();
            })
        ];
    }
}
