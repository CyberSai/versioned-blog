<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\JsonResource;

/** @version 1 */
class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user' => new UserResource($this->whenLoaded('user')),
            $this->mergeWhen($request->route('version') >= 2, [
                'category' => new CategoryResource($this->whenLoaded('category')),
            ]),
        ];
    }
}
