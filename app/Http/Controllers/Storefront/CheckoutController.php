<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class CheckoutController extends Controller
{
    public function __construct(private readonly CartService $cart)
    {
    }

    public function index(Request $request): Response
    {
        $summary = $this->cart->summary();

        return Inertia::render('Checkout/Index', [
            'summary' => $summary,
            'user' => $request->user(),
        ]);
    }

    public function place(Request $request)
    {
        $summary = $this->cart->summary();

        if ($summary['count'] === 0) {
            return back()->with('error', 'Корзина пуста.');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_postcode' => ['nullable', 'string', 'max:20'],
            'shipping_street' => ['required', 'string', 'max:255'],
            'shipping_apartment' => ['nullable', 'string', 'max:50'],
            'payment_method' => ['required', 'in:cod,card'],
            'shipping_method' => ['required', 'in:courier,pickup'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $order = DB::transaction(function () use ($summary, $data, $request) {
            $order = Order::create(array_merge($data, [
                'number' => Order::generateNumber(),
                'user_id' => $request->user()?->id,
                'shipping_country' => 'Russia',
                'subtotal' => $summary['subtotal'],
                'shipping_total' => $summary['shipping'],
                'discount_total' => $summary['discount'],
                'total' => $summary['total'],
                'status' => Order::STATUS_NEW,
                'payment_status' => 'pending',
            ]));

            foreach ($summary['items'] as $item) {
                $product = Product::find($item['product_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'],
                    'product_image' => $item['image'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['total'],
                ]);

                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            return $order;
        });

        $this->cart->clear();

        return redirect()->route('checkout.success', $order)->with('success', 'Заказ оформлен!');
    }

    public function success(Order $order): Response
    {
        $order->load('items');

        return Inertia::render('Checkout/Success', [
            'order' => $order,
        ]);
    }
}
