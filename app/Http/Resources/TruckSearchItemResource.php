<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TruckSearchItemResource extends JsonResource
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
            'id' => $this->truck->id,
            'doc_uid' => $this->truck->doc_uid,
            'subscriber_id' => $this->subscriber_id,
            'available_date' => $this->available_date,
            'city_name' => $this->city_name,
            'city_name2' => $this->truck->city_name2,
            'body_type' => $this->truck->body_type_name,
            'weight' => $this->weight,
            'volume' => $this->volume,
            'length' => $this->truck->length,
            'width' => $this->truck->width,
            'height' => $this->truck->height,
            'organization' => $this->truck->organization,
            'organization_inn' => $this->truck->organization_inn,
            'manager' => $this->truck->manager,
            'manager_work_phone' => $this->truck->manager_work_phone,
            'manager_contacts' => $this->truck->manager_contacts,
            'manager_icq' => $this->truck->manager_icq,
            'rank' => $this->rank ?: 0,
        ];
    }
}
