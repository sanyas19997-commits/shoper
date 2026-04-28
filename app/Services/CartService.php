<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'cart.items';

    /** @return array<int, array{product_id:int,quantity:int}> */
    public function raw(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $items = $this->raw();

        $existing = collect($items)->search(fn ($i) => $i['product_id'] === $productId);

        if ($existing !== false) {
            $items[$existing]['quantity'] += $quantity;
        } else {
            $items[] = ['product_id' => $productId, 'quantity' => $quantity];
        }

        Session::put(self::SESSION_KEY, array_values($items));
    }

    public function update(int $productId, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->remove($productId);

            return;
        }

        $items = $this->raw();
        foreach ($items as &$item) {
            if ($item['product_id'] === $productId) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        Session::put(self::SESSION_KEY, $items);
    }

    public function remove(int $productId): void
    {
        $items = collect($this->raw())->reject(fn ($i) => $i['product_id'] === $productId)->values()->all();
        Session::put(self::SESSION_KEY, $items);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function totalQuantity(): int
    {
        return (int) collect($this->raw())->sum('quantity');
    }

    public function detailedItems(): Collection
    {
        $items = $this->raw();
        if (empty($items)) {
            return collect();
        }

        $ids = collect($items)->pluck('product_id')->all();
        $products = Product::with('mainImage')->whereIn('id', $ids)->get()->keyBy('id');

        return collect($items)
            ->filter(fn ($i) => $products->has($i['product_id']))
            ->map(function ($i) use ($products) {
                $p = $products->get($i['product_id']);
                $price = $p->effective_price;

                return [
                    'product_id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'sku' => $p->sku,
                    'image' => optional($p->mainImage ?: $p->images()->first())->url,
                    'price' => (float) $price,
                    'quantity' => $i['quantity'],
                    'total' => round($price * $i['quantity'], 2),
                    'in_stock' => $p->stock >= $i['quantity'],
                ];
            })
            ->values();
    }

    public function summary(): array
    {
        $items = $this->detailedItems();
        $subtotal = round($items->sum('total'), 2);

        return [
            'items' => $items,
            'count' => $items->sum('quantity'),
            'subtotal' => $subtotal,
            'shipping' => 0.0,
            'discount' => 0.0,
            'total' => $subtotal,
        ];
    }
}
