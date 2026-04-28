<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Product::with('category', 'mainImage');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->query('category_id'));
        }

        return Inertia::render('Admin/Products/Index', [
            'products' => $query->latest()->paginate(20)->withQueryString(),
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'filters' => $request->only(['search', 'category_id']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Products/Form', [
            'product' => null,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']).'-'.uniqid();

        $product = Product::create($data);

        $this->syncImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Товар создан.');
    }

    public function edit(Product $product): Response
    {
        $product->load('images');

        return Inertia::render('Admin/Products/Form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product->id);
        $data['slug'] = $data['slug'] ?: $product->slug;

        $product->update($data);

        $this->syncImages($request, $product);

        return redirect()->route('admin.products.edit', $product)->with('success', 'Товар обновлён.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Товар удалён.');
    }

    public function deleteImage(ProductImage $image)
    {
        if (! str_starts_with($image->path, 'kidify/')) {
            Storage::disk('public')->delete($image->path);
        }
        $image->delete();

        return back()->with('success', 'Изображение удалено.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $rule = 'unique:products,slug';
        if ($ignoreId) {
            $rule .= ','.$ignoreId;
        }

        $skuRule = 'unique:products,sku';
        if ($ignoreId) {
            $skuRule .= ','.$ignoreId;
        }

        return $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $rule],
            'sku' => ['nullable', 'string', 'max:100', $skuRule],
            'brand' => ['nullable', 'string', 'max:100'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_new' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function syncImages(Request $request, Product $product): void
    {
        if ($request->hasFile('images')) {
            $existing = $product->images()->count();
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'alt' => $product->name,
                    'is_main' => $existing === 0 && $i === 0,
                    'sort_order' => $existing + $i,
                ]);
            }
        }
    }
}
