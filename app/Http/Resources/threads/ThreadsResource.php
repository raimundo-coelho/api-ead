<?php

namespace IDEALE\Http\Resources\threads;


use IDEALE\Http\Resources\replies\RepliesResource;
use IDEALE\Http\Resources\user\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'body' => $this->body,
            'user' => new UserResource($this->user),
            'replies' => RepliesResource::collection($this->replies),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
