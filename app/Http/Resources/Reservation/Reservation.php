<?php

namespace App\Http\Resources\Reservation;

use App\Http\Resources\Restaurant\Restaurant;
use App\Http\Resources\Table\Table;
use App\Http\Resources\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Reservation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user" => new User($this->user),
            "restaurant" => new Restaurant($this->restaurant),
            "table" => new Table($this->table),
            "reservation_date" => $this->reservation_date
        ];
    }
}