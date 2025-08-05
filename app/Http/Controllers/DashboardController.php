<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->isSuperAdmin()) {
            return $this->superAdminDashboard();
        } else {
            return $this->storeAdminDashboard($user);
        }
    }

    /**
     * Display the Super Admin dashboard.
     */
    protected function superAdminDashboard()
    {
        $totalStores = Store::count();
        $activeStores = Store::active()->count();
        $totalSales = Order::whereIn('status', ['completed', 'delivered'])->sum('total_amount');
        $activeOrders = Order::whereIn('status', ['pending', 'processing', 'shipped'])->count();
        
        $recentStores = Store::with('users')
            ->latest()
            ->take(5)
            ->get();
            
        $recentActivity = ActivityLog::with(['user', 'store'])
            ->latest()
            ->take(10)
            ->get();
            
        $salesByStore = Store::withCount('orders')
            ->with(['orders' => function ($query) {
                $query->whereIn('status', ['completed', 'delivered'])
                    ->selectRaw('store_id, SUM(total_amount) as total_sales')
                    ->groupBy('store_id');
            }])
            ->take(10)
            ->get();

        return Inertia::render('dashboard/super-admin', [
            'stats' => [
                'totalStores' => $totalStores,
                'activeStores' => $activeStores,
                'totalSales' => $totalSales,
                'activeOrders' => $activeOrders,
            ],
            'recentStores' => $recentStores,
            'recentActivity' => $recentActivity,
            'salesByStore' => $salesByStore,
        ]);
    }

    /**
     * Display the Store Admin dashboard.
     */
    protected function storeAdminDashboard($user)
    {
        $storeId = $user->store_id;
        
        $totalRevenue = Order::where('store_id', $storeId)
            ->whereIn('status', ['completed', 'delivered'])
            ->sum('total_amount');
            
        $totalOrders = Order::where('store_id', $storeId)->count();
        
        $lowStockProducts = Product::where('store_id', $storeId)
            ->lowStock(10)
            ->available()
            ->count();
            
        $topSellingProducts = Product::where('store_id', $storeId)
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();
            
        $recentOrders = Order::where('store_id', $storeId)
            ->with(['customer', 'items.product'])
            ->latest()
            ->take(10)
            ->get();
            
        $monthlyRevenue = Order::where('store_id', $storeId)
            ->whereIn('status', ['completed', 'delivered'])
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');
            
        $customerCount = Customer::where('store_id', $storeId)->active()->count();

        return Inertia::render('dashboard/store-admin', [
            'stats' => [
                'totalRevenue' => $totalRevenue,
                'monthlyRevenue' => $monthlyRevenue,
                'totalOrders' => $totalOrders,
                'customerCount' => $customerCount,
                'lowStockProducts' => $lowStockProducts,
            ],
            'topSellingProducts' => $topSellingProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}