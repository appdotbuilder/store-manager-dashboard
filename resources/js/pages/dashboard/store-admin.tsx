import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Head } from '@inertiajs/react';

interface Props {
    stats: {
        totalRevenue: number;
        monthlyRevenue: number;
        totalOrders: number;
        customerCount: number;
        lowStockProducts: number;
    };
    topSellingProducts: Array<{
        id: number;
        name: string;
        price: number;
        stock_quantity: number;
        order_items_count: number;
    }>;
    recentOrders: Array<{
        id: number;
        order_number: string;
        status: string;
        total_amount: number;
        created_at: string;
        customer: {
            name: string;
            phone: string;
        };
        items: Array<{
            quantity: number;
            product: {
                name: string;
            };
        }>;
    }>;
    [key: string]: unknown;
}

export default function StoreAdminDashboard({ stats, topSellingProducts, recentOrders }: Props) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        }).format(amount);
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    };

    const getStatusColor = (status: string) => {
        const colors = {
            pending: 'bg-yellow-100 text-yellow-800',
            processing: 'bg-blue-100 text-blue-800',
            shipped: 'bg-purple-100 text-purple-800',
            delivered: 'bg-green-100 text-green-800',
            completed: 'bg-green-100 text-green-800',
            canceled: 'bg-red-100 text-red-800',
        };
        return colors[status as keyof typeof colors] || 'bg-gray-100 text-gray-800';
    };

    return (
        <AppShell>
            <Head title="Store Dashboard" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-800">🏪 Store Dashboard</h1>
                        <p className="text-gray-600">Monitor your store performance and manage operations</p>
                    </div>
                    <div className="text-sm text-gray-500">
                        Last updated: {new Date().toLocaleTimeString()}
                    </div>
                </div>

                {/* Stats Grid */}
                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-100">
                                <span className="text-2xl">💰</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600">Total Revenue</p>
                                <p className="text-xl font-bold text-gray-800">{formatCurrency(stats.totalRevenue)}</p>
                            </div>
                        </div>
                    </div>

                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                                <span className="text-2xl">📈</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600">This Month</p>
                                <p className="text-xl font-bold text-gray-800">{formatCurrency(stats.monthlyRevenue)}</p>
                            </div>
                        </div>
                    </div>

                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100">
                                <span className="text-2xl">📦</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600">Total Orders</p>
                                <p className="text-xl font-bold text-gray-800">{stats.totalOrders}</p>
                            </div>
                        </div>
                    </div>

                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100">
                                <span className="text-2xl">👥</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600">Customers</p>
                                <p className="text-xl font-bold text-gray-800">{stats.customerCount}</p>
                            </div>
                        </div>
                    </div>

                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-red-100">
                                <span className="text-2xl">⚠️</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600">Low Stock</p>
                                <p className="text-xl font-bold text-gray-800">{stats.lowStockProducts}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Main Content Grid */}
                <div className="grid gap-6 lg:grid-cols-2">
                    {/* Top Selling Products */}
                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="mb-6 flex items-center justify-between">
                            <h2 className="text-lg font-semibold text-gray-800">🔥 Top Selling Products</h2>
                            <a href="/products" className="text-sm text-blue-600 hover:text-blue-800">
                                Manage products
                            </a>
                        </div>
                        <div className="space-y-4">
                            {topSellingProducts.map((product, index) => (
                                <div key={product.id} className="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <div className="flex items-center">
                                        <div className="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-600">
                                            {index + 1}
                                        </div>
                                        <div className="ml-3">
                                            <p className="font-medium text-gray-800">{product.name}</p>
                                            <p className="text-sm text-gray-500">
                                                {formatCurrency(product.price)} • Stock: {product.stock_quantity}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="text-right">
                                        <p className="font-semibold text-emerald-600">{product.order_items_count} sold</p>
                                    </div>
                                </div>
                            ))}
                            {topSellingProducts.length === 0 && (
                                <p className="text-center text-gray-500 py-8">No sales data available yet</p>
                            )}
                        </div>
                    </div>

                    {/* Recent Orders */}
                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="mb-6 flex items-center justify-between">
                            <h2 className="text-lg font-semibold text-gray-800">📦 Recent Orders</h2>
                            <a href="/orders" className="text-sm text-blue-600 hover:text-blue-800">
                                View all orders
                            </a>
                        </div>
                        <div className="space-y-4">
                            {recentOrders.map((order) => (
                                <div key={order.id} className="border-b border-gray-100 pb-3">
                                    <div className="flex items-center justify-between">
                                        <div>
                                            <p className="font-medium text-gray-800">#{order.order_number}</p>
                                            <p className="text-sm text-gray-600">{order.customer.name}</p>
                                        </div>
                                        <div className="text-right">
                                            <p className="font-semibold text-gray-800">{formatCurrency(order.total_amount)}</p>
                                            <span className={`inline-flex rounded-full px-2 py-1 text-xs font-medium ${getStatusColor(order.status)}`}>
                                                {order.status}
                                            </span>
                                        </div>
                                    </div>
                                    <div className="mt-2 flex items-center justify-between text-sm text-gray-500">
                                        <span>
                                            {order.items.reduce((sum, item) => sum + item.quantity, 0)} items
                                        </span>
                                        <span>{formatDate(order.created_at)}</span>
                                    </div>
                                </div>
                            ))}
                            {recentOrders.length === 0 && (
                                <p className="text-center text-gray-500 py-8">No orders yet</p>
                            )}
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                    <h2 className="mb-6 text-lg font-semibold text-gray-800">⚡ Quick Actions</h2>
                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <a
                            href="/products/create"
                            className="flex items-center rounded-lg border border-gray-200 p-4 transition-colors hover:bg-gray-50"
                        >
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100">
                                <span className="text-lg">➕</span>
                            </div>
                            <div className="ml-3">
                                <p className="font-medium text-gray-800">Add Product</p>
                                <p className="text-sm text-gray-500">Create new product</p>
                            </div>
                        </a>

                        <a
                            href="/orders"
                            className="flex items-center rounded-lg border border-gray-200 p-4 transition-colors hover:bg-gray-50"
                        >
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                                <span className="text-lg">📋</span>
                            </div>
                            <div className="ml-3">
                                <p className="font-medium text-gray-800">Process Orders</p>
                                <p className="text-sm text-gray-500">Update order status</p>
                            </div>
                        </a>

                        <a
                            href="/customers"
                            className="flex items-center rounded-lg border border-gray-200 p-4 transition-colors hover:bg-gray-50"
                        >
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100">
                                <span className="text-lg">👥</span>
                            </div>
                            <div className="ml-3">
                                <p className="font-medium text-gray-800">View Customers</p>
                                <p className="text-sm text-gray-500">Customer management</p>
                            </div>
                        </a>

                        <a
                            href="/notifications/create"
                            className="flex items-center rounded-lg border border-gray-200 p-4 transition-colors hover:bg-gray-50"
                        >
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100">
                                <span className="text-lg">📨</span>
                            </div>
                            <div className="ml-3">
                                <p className="font-medium text-gray-800">Send Notification</p>
                                <p className="text-sm text-gray-500">Marketing campaign</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}