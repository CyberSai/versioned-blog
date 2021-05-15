<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\JsonResource;

/** @version 1 */
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($request->routeIs('users.index')) {
            return Arr::only($data, ['id', 'email', 'name']);
        }

        if ($request->routeIs('users.store')) {
            return Arr::add($data, 'api_token', $this->api_token);
        }

        return $data;
    }
}
