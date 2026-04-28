<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalogController extends Controller
{
    public function index(Request $request, ?Category $category = null): Response
    {
        $query = Product::active()->with('mainImage', 'images', 'category');

        if ($category) {
            $query->where('category_id', $category->id);
        }

        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->query('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->query('max_price'));
        }

        if ($request->filled('on_sale')) {
            $query->whereNotNull('sale_price');
        }

        $sort = $request->query('sort', 'popular');
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'newest' => $query->latest(),
            default => $query->orderBy('sort_order')->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('Catalog/Index', [
            'products' => $products,
            'categories' => Category::active()->orderBy('sort_order')->get(),
            'currentCategory' => $category,
            'filters' => [
                'search' => $search,
                'min_price' => $request->query('min_price'),
                'max_price' => $request->query('max_price'),
                'on_sale' => (bool) $request->query('on_sale'),
                'sort' => $sort,
            ],
            'priceRange' => [
                'min' => (int) Product::active()->min('price'),
                'max' => (int) Product::active()->max('price'),
            ],
        ]);
    }
}
