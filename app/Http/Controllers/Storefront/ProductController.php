<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function show(Product $product): Response
    {
        abort_unless($product->is_active, 404);

        $product->load('images', 'category');

        $related = Product::active()
            ->with('mainImage')
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->limit(4)
            ->get();

        return Inertia::render('Product/Show', [
            'product' => $product,
            'related' => $related,
        ]);
    }
}
