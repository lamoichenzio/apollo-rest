<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationPoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'password' => $this->password,
            'emails' => $this->emails->map(function ($email) {
                return ['id' => $email->id, 'email' => $email->email];
            })
        ];
    }
}
