import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Head } from '@inertiajs/react';

interface Props {
    stats: {
        totalStores: number;
        activeStores: number;
        totalSales: number;
        activeOrders: number;
    };
    recentStores: Array<{
        id: number;
        name: string;
        slug: string;
        is_active: boolean;
        created_at: string;
        users_count?: number;
    }>;
    recentActivity: Array<{
        id: number;
        description: string;
        created_at: string;
        user: {
            name: string;
        };
        store?: {
            name: string;
        };
    }>;
    salesByStore: Array<{
        id: number;
        name: string;
        orders_count: number;
        orders: Array<{
            total_sales: number;
        }>;
    }>;
    [key: string]: unknown;
}

export default function SuperAdminDashboard({ stats, recentStores, recentActivity, salesByStore }: Props) {
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
            year: 'numeric',
        });
    };

    return (
        <AppShell>
            <Head title="Super Admin Dashboard" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-800">👑 Super Admin Dashboard</h1>
                        <p className="text-gray-600">Manage all stores and monitor system-wide performance</p>
                    </div>
                    <div className="text-sm text-gray-500">
                        Last updated: {new Date().toLocaleTimeString()}
                    </div>
                </div>

                {/* Stats Grid */}
                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                                <span className="text-2xl">🏪</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600">Total Stores</p>
                                <p className="text-2xl font-bold text-gray-800">{stats.totalStores}</p>
                            </div>
                        </div>
                        <p className="mt-2 text-sm text-gray-500">
                            <span className="text-green-600">{stats.activeStores}</span> active
                        </p>
                    </div>

                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-100">
                                <span className="text-2xl">💰</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600">Total Sales</p>
                                <p className="text-2xl font-bold text-gray-800">{formatCurrency(stats.totalSales)}</p>
                            </div>
                        </div>
                        <p className="mt-2 text-sm text-green-600">All-time revenue</p>
                    </div>

                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100">
                                <span className="text-2xl">📦</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600">Active Orders</p>
                                <p className="text-2xl font-bold text-gray-800">{stats.activeOrders}</p>
                            </div>
                        </div>
                        <p className="mt-2 text-sm text-gray-500">Pending processing</p>
                    </div>

                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="flex items-center">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100">
                                <span className="text-2xl">📊</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600">System Health</p>
                                <p className="text-2xl font-bold text-green-600">Good</p>
                            </div>
                        </div>
                        <p className="mt-2 text-sm text-gray-500">All systems operational</p>
                    </div>
                </div>

                {/* Main Content Grid */}
                <div className="grid gap-6 lg:grid-cols-2">
                    {/* Recent Stores */}
                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="mb-6 flex items-center justify-between">
                            <h2 className="text-lg font-semibold text-gray-800">Recent Stores</h2>
                            <a href="/stores" className="text-sm text-blue-600 hover:text-blue-800">
                                View all
                            </a>
                        </div>
                        <div className="space-y-4">
                            {recentStores.map((store) => (
                                <div key={store.id} className="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <div className="flex items-center">
                                        <div className={`h-3 w-3 rounded-full ${store.is_active ? 'bg-green-500' : 'bg-gray-400'}`}></div>
                                        <div className="ml-3">
                                            <p className="font-medium text-gray-800">{store.name}</p>
                                            <p className="text-sm text-gray-500">Created {formatDate(store.created_at)}</p>
                                        </div>
                                    </div>
                                    <div className="text-right">
                                        <p className="text-sm text-gray-600">{store.users_count || 0} users</p>
                                        <a href={`/stores/${store.id}`} className="text-sm text-blue-600 hover:text-blue-800">
                                            View →
                                        </a>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Recent Activity */}
                    <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                        <div className="mb-6 flex items-center justify-between">
                            <h2 className="text-lg font-semibold text-gray-800">Recent Activity</h2>
                            <a href="/activity-logs" className="text-sm text-blue-600 hover:text-blue-800">
                                View all
                            </a>
                        </div>
                        <div className="space-y-4">
                            {recentActivity.map((activity) => (
                                <div key={activity.id} className="flex items-start space-x-3 border-b border-gray-100 pb-3">
                                    <div className="h-2 w-2 mt-2 rounded-full bg-blue-500"></div>
                                    <div className="flex-1">
                                        <p className="text-sm text-gray-800">{activity.description}</p>
                                        <div className="mt-1 flex items-center space-x-2 text-xs text-gray-500">
                                            <span>{activity.user.name}</span>
                                            {activity.store && (
                                                <>
                                                    <span>•</span>
                                                    <span>{activity.store.name}</span>
                                                </>
                                            )}
                                            <span>•</span>
                                            <span>{formatDate(activity.created_at)}</span>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* Sales by Store */}
                <div className="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
                    <div className="mb-6 flex items-center justify-between">
                        <h2 className="text-lg font-semibold text-gray-800">Top Performing Stores</h2>
                        <a href="/reports" className="text-sm text-blue-600 hover:text-blue-800">
                            View reports
                        </a>
                    </div>
                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {salesByStore.map((store) => (
                            <div key={store.id} className="rounded-lg border border-gray-200 p-4">
                                <h3 className="font-medium text-gray-800">{store.name}</h3>
                                <div className="mt-2 flex items-center justify-between">
                                    <div>
                                        <p className="text-sm text-gray-600">{store.orders_count} orders</p>
                                        <p className="font-semibold text-emerald-600">
                                            {formatCurrency(store.orders[0]?.total_sales || 0)}
                                        </p>
                                    </div>
                                    <a href={`/stores/${store.id}`} className="text-sm text-blue-600 hover:text-blue-800">
                                        View →
                                    </a>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppShell>
    );
}