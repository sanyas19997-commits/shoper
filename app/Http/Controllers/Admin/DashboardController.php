<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'products' => Product::count(),
                'productsActive' => Product::where('is_active', true)->count(),
                'orders' => Order::count(),
                'ordersNew' => Order::where('status', Order::STATUS_NEW)->count(),
                'users' => User::count(),
                'revenue' => round(Order::where('status', '!=', Order::STATUS_CANCELLED)->sum('total'), 2),
            ],
            'recentOrders' => Order::latest()->limit(8)->get(),
            'topProducts' => Product::with('mainImage')->orderByDesc('is_featured')->limit(8)->get(),
        ]);
    }
}
