<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            "key" => $this->key,
            "icon"=> public_path() . '\\images\\' . $this->icon,
            "description" => $this->description,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
