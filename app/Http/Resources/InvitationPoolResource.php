<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

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
            'password' => Crypt::decryptString($this->password),
            'emails' => $this->emails->map(function ($email) {
                return ['id' => $email->id, 'email' => $email->email];
            })
        ];
    }
}
