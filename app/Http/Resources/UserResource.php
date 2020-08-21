<?php

namespace App\Http\Resources;

use App\Services\ImageFileService;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $image = ImageFileService::getImageFilePath($this->avatar);
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'avatar' => $image,
            'role' => $this->role,
            'surveys' => $this->surveys->map(function ($survey) {
                return $survey->path();
            })
        ];
    }
}
