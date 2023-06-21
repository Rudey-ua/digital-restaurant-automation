<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderCollection;
use App\Models\Order;
use App\Models\Reservation;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Table;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Payment\PaymentResource as PaymentResource;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::all();

        return response()->json([
            "orders" => new OrderCollection($orders)
        ]);
    }

    public function show(Order $order): JsonResponse
    {
        return response()->json(new OrderResource($order));
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        //TODO: make booking without reservation
        /*if(!isset($request['reservation_id'])) {
            $freeTable = Table::where('status', 'free')->inRandomOrder()->first();

            $reservation = Reservation::create([
                "table_id" => $freeTable->id,
                "reservation_date" => now(),
                "note" => null,
                "guests_number" => null,
                "user_id" => null
            ]);
        }*/

        $reservation = Reservation::find($request['reservation_id']);

        try {
            $userData = $request->validated();
            $userData['user_id'] = auth()->user()->id;

            OrderService::assertOrderDoesNotExist($reservation->id);
            $order = OrderService::createOrder($userData);
            $payment = OrderService::createPayment($order, $userData);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json([
            'order' => new OrderResource($order),
            'reservation' => new ReservationResource($reservation),
            'payment' => new PaymentResource($payment)
        ], 201);
    }

    public function destroy(Order $order): JsonResponse
    {
        $table = $order->table;
        $table->status = 'free';
        $table->save();

        $order->delete();
        return response()->json(null, 204);
    }
}
