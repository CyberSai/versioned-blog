<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\JsonResource;

/** @version 1 */
class PostResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);

        if ($request->route('version') < 2) {
            return Arr::except($data, 'category_id');
        }
        
        return parent::toArray($request);
    }
}
