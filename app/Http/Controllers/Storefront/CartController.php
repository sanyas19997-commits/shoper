<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart)
    {
    }

    public function index(): Response
    {
        return Inertia::render('Cart/Index', [
            'summary' => $this->cart->summary(),
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::active()->findOrFail($data['product_id']);
        $qty = $data['quantity'] ?? 1;

        if ($product->stock < $qty) {
            return back()->with('error', 'Недостаточно товара на складе.');
        }

        $this->cart->add($product->id, $qty);

        return back()->with('success', 'Товар добавлен в корзину.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $this->cart->update($data['product_id'], $data['quantity']);

        return back();
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $this->cart->remove($data['product_id']);

        return back()->with('success', 'Товар удалён из корзины.');
    }

    public function clear()
    {
        $this->cart->clear();

        return back()->with('success', 'Корзина очищена.');
    }
}
