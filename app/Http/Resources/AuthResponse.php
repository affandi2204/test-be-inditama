<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($responsee)
    {
        return [
            'id'     => $this['user']->id,
            'name'   => $this['user']->name,
            'email'  => $this['user']->email,
            'login_at'  => $this['user']->login_at,
            'token'  => $this['token'],
        ];
    }
}
