<?php

namespace App\Http\Resources;

use App\ImageFile;
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
        $image = null;
        if ($this->icon) $image = ImageFileResource::make(ImageFile::find($this->icon));
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $image,
            'secret' => $this->secret,
            'active' => $this->active,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'urlId' => $this->url_id,
            'user' => $this->user->path(),
            'questionGroups' => $this->questionGroups->map(function ($questionGroup) {
                return $questionGroup->path();
            }),
            'invitationPool' => new InvitationPoolResource($this->invitationPool),
            'createDate' => $this->created_at,
        ];
    }
}
