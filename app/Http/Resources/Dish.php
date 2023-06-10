<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Dish extends JsonResource
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
            "name" => $this->name,
            "price" => $this->price,
            "category_id" => new Category($this->category),
            "ingredients" => $this->ingredients,
            "special_requirements" => $this->special_requirements,
            "recipe" => $this->recipe,
            "restaurant_id" => new Restaurant($this->restaurant)
        ];
    }
}