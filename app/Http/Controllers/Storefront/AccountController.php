<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    public function index(Request $request): Response
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->latest()
            ->with('items')
            ->limit(20)
            ->get();

        return Inertia::render('Account/Index', [
            'orders' => $orders,
        ]);
    }

    public function showOrder(Request $request, Order $order): Response
    {
        abort_unless($order->user_id === $request->user()->id, 404);
        $order->load('items');

        return Inertia::render('Account/Order', [
            'order' => $order,
        ]);
    }
}
