<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantCollection;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $products = Restaurant::all();
        return response()->json([
            "status" => true,
            "restaurants" => new RestaurantCollection($products)
        ], 200)->setStatusCode(200, 'The resource has been fetched and transmitted in the message body.');
    }

    public function show($id)
    {
        $product = Restaurant::find($id);

        if(!$product) return response()->json([
            "status" => false,
            "message" => "Product not found!"
        ], 404)->setStatusCode(404, 'Product not found!');

        return response()->json([
            "status" => true,
            "product" => new ProductResource($product)
        ], 200);
    }
}
