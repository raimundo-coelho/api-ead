<?php

namespace IDEALE\Http\Resources\reply;

use IDEALE\Http\Resources\replies\RepliesResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReplyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($reply){
                return new RepliesResource($reply);
            })
        ];
    }
}
