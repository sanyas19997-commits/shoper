<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $featured = Product::active()
            ->with('mainImage', 'images', 'category')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $newArrivals = Product::active()
            ->with('mainImage', 'images', 'category')
            ->where('is_new', true)
            ->latest()
            ->limit(8)
            ->get();

        $onSale = Product::active()
            ->with('mainImage', 'images', 'category')
            ->whereNotNull('sale_price')
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $categories = Category::active()->orderBy('sort_order')->get();

        return Inertia::render('Home', [
            'featured' => $featured,
            'newArrivals' => $newArrivals,
            'onSale' => $onSale,
            'categories' => $categories,
        ]);
    }
}
