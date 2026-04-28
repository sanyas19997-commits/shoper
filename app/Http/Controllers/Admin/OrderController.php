<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Order::query();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $query->latest()->paginate(25)->withQueryString(),
            'statuses' => Order::STATUSES,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    public function show(Order $order): Response
    {
        $order->load('items', 'user');

        return Inertia::render('Admin/Orders/Show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(Order::STATUSES))],
        ]);

        $order->status = $data['status'];

        if ($data['status'] === Order::STATUS_SHIPPED && ! $order->shipped_at) {
            $order->shipped_at = now();
        } elseif ($data['status'] === Order::STATUS_COMPLETED && ! $order->completed_at) {
            $order->completed_at = now();
        } elseif ($data['status'] === Order::STATUS_CANCELLED && ! $order->cancelled_at) {
            $order->cancelled_at = now();
        }

        $order->save();

        return back()->with('success', 'Статус заказа обновлён.');
    }
}
