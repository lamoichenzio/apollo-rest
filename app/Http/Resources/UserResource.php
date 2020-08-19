<?php

namespace App\Http\Resources;

use App\ImageFile;
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
        if ($image = ImageFile::find($this->pic)) {
            $image = $image->path();
        }
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'pic' => $image,
            'role' => $this->role,
            'surveys' => $this->surveys
        ];
    }
}
