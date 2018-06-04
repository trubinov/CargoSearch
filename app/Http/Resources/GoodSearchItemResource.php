<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodSearchItemResource extends JsonResource
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
            'id' => $this->good->id,
            'good_uid' => $this->good->good_uid,
            'subscriber_id' => $this->subscriber_id,
            'loading_city_name' => $this->loading_city_name,
            'unloading_city_name' => $this->unloading_city_name,
            'load_date' => $this->load_date,
            'load_date_to' => $this->load_date_to,
            'distance' => $this->good->distance,
            'description' => $this->good->description,
            'weight' => $this->weight,
            'volume' => $this->volume,
            'price' => $this->price,
            'bodies_list' => $this->bodies_list,
            'organization' => $this->good->organization,
            'manager' => $this->good->manager,
            'manager_work_phone' => $this->good->manager_work_phone,
            'manager_contacts' => $this->good->manager_contacts,
            'manager_icq' => $this->good->manager_icq,
        ];
    }
}
