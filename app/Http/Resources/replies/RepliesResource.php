<?php

namespace IDEALE\Http\Resources\replies;

use Illuminate\Http\Resources\Json\JsonResource;

class RepliesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => $this->user,
            'thread_id' =>  $this->thread_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}