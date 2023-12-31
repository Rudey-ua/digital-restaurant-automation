<?php

namespace App\Http\Controllers;

use App\Http\Filters\Dish\ByCategory;
use App\Http\Filters\Dish\ByName;
use App\Http\Filters\Dish\ByPrice;
use App\Http\Requests\Dish\StoreDishRequest;
use App\Http\Requests\Dish\UpdateDishRequest;
use App\Http\Resources\Dish\DishResource;
use App\Http\Resources\Dish\DishCollection;
use App\Models\Dish;
use App\Services\DishService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Pipeline;

class DishController extends Controller
{
    public function __construct(protected DishService $dishService){}

    public function index(): JsonResponse
    {
        $pipelines = [
            ByName::class, ByCategory::class, ByPrice::class
        ];

        $dishes = Pipeline::send(Dish::query())
            ->through($pipelines)
            ->thenReturn()
            ->get();

        return response()->json([
            "dishes" => new DishCollection($dishes)
        ]);
    }

    public function show(Dish $dish): JsonResponse
    {
        return response()->json(new DishResource($dish));
    }

    public function store(StoreDishRequest $request): JsonResponse
    {
        $data = $request->except('images');
        $dish = Dish::create($data);

        if ($request->hasFile('images')) {
            $this->dishService->saveImages($dish, $request->file('images'));
        }

        return response()->json(new DishResource($dish), 201);
    }

    public function update(UpdateDishRequest $request, Dish $dish): JsonResponse
    {
        $dish->update($request->validated());

        return response()->json(new DishResource($dish));
    }

    public function destroy(Dish $dish): JsonResponse
    {
        $dish->delete();

        return response()->json(null, 204);
    }

    public function getRestaurantDishes($restaurant_id): JsonResponse
    {
        $dish = Dish::where('restaurant_id', $restaurant_id)->get();

        return response()->json([
            'dishes' => new DishCollection($dish),
        ]);
    }
}
