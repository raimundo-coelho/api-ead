<?php

namespace IDEALE\Http\Resources\manager;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ManagerCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($manager){
                return new ManagerResource($manager);
            })
        ];
    }
}
