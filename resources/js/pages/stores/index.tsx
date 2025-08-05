import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Head, Link } from '@inertiajs/react';

interface Store {
    id: number;
    name: string;
    slug: string;
    email: string | null;
    phone: string | null;
    is_active: boolean;
    created_at: string;
    users_count?: number;
    orders_count?: number;
    products_count?: number;
    customers_count?: number;
}

interface Props {
    stores: {
        data: Store[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    [key: string]: unknown;
}

export default function StoresIndex({ stores }: Props) {
    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
        });
    };

    return (
        <AppShell>
            <Head title="Stores Management" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-800">🏪 Stores Management</h1>
                        <p className="text-gray-600">Manage all stores in the system</p>
                    </div>
                    <Link
                        href="/stores/create"
                        className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                    >
                        + Add New Store
                    </Link>
                </div>

                {/* Stats */}
                <div className="grid gap-4 sm:grid-cols-4">
                    <div className="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
                        <div className="text-2xl font-bold text-blue-600">{stores.total}</div>
                        <div className="text-sm text-gray-600">Total Stores</div>
                    </div>
                    <div className="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
                        <div className="text-2xl font-bold text-green-600">
                            {stores.data.filter(store => store.is_active).length}
                        </div>
                        <div className="text-sm text-gray-600">Active Stores</div>
                    </div>
                    <div className="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
                        <div className="text-2xl font-bold text-purple-600">
                            {stores.data.reduce((sum, store) => sum + (store.products_count || 0), 0)}
                        </div>
                        <div className="text-sm text-gray-600">Total Products</div>
                    </div>
                    <div className="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
                        <div className="text-2xl font-bold text-orange-600">
                            {stores.data.reduce((sum, store) => sum + (store.orders_count || 0), 0)}
                        </div>
                        <div className="text-sm text-gray-600">Total Orders</div>
                    </div>
                </div>

                {/* Stores Table */}
                <div className="rounded-lg bg-white shadow-sm border border-gray-200">
                    <div className="px-6 py-4 border-b border-gray-200">
                        <h2 className="text-lg font-semibold text-gray-800">All Stores</h2>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="w-full">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Store
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Contact
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Stats
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Status
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Created
                                    </th>
                                    <th className="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-200 bg-white">
                                {stores.data.map((store) => (
                                    <tr key={store.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4">
                                            <div>
                                                <Link
                                                    href={`/stores/${store.id}`}
                                                    className="font-medium text-gray-800 hover:text-blue-600"
                                                >
                                                    {store.name}
                                                </Link>
                                                <div className="text-sm text-gray-500">/{store.slug}</div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="text-sm">
                                                {store.email && (
                                                    <div className="text-gray-800">{store.email}</div>
                                                )}
                                                {store.phone && (
                                                    <div className="text-gray-500">{store.phone}</div>
                                                )}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="text-sm">
                                                <div className="text-gray-800">
                                                    {store.products_count || 0} products
                                                </div>
                                                <div className="text-gray-500">
                                                    {store.orders_count || 0} orders
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className={`inline-flex rounded-full px-2 py-1 text-xs font-semibold ${
                                                store.is_active 
                                                    ? 'bg-green-100 text-green-800' 
                                                    : 'bg-red-100 text-red-800'
                                            }`}>
                                                {store.is_active ? 'Active' : 'Inactive'}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-500">
                                            {formatDate(store.created_at)}
                                        </td>
                                        <td className="px-6 py-4 text-right">
                                            <div className="flex items-center justify-end space-x-2">
                                                <Link
                                                    href={`/stores/${store.id}`}
                                                    className="text-blue-600 hover:text-blue-800 text-sm"
                                                >
                                                    View
                                                </Link>
                                                <Link
                                                    href={`/stores/${store.id}/edit`}
                                                    className="text-gray-600 hover:text-gray-800 text-sm"
                                                >
                                                    Edit
                                                </Link>

                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    
                    {stores.data.length === 0 && (
                        <div className="px-6 py-12 text-center">
                            <div className="text-6xl mb-4">🏪</div>
                            <h3 className="text-lg font-medium text-gray-800 mb-2">No stores yet</h3>
                            <p className="text-gray-500 mb-6">Get started by creating your first store.</p>
                            <Link
                                href="/stores/create"
                                className="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                            >
                                + Create First Store
                            </Link>
                        </div>
                    )}
                </div>

                {/* Pagination */}
                {stores.last_page > 1 && (
                    <div className="flex items-center justify-between">
                        <div className="text-sm text-gray-700">
                            Showing {((stores.current_page - 1) * stores.per_page) + 1} to {Math.min(stores.current_page * stores.per_page, stores.total)} of {stores.total} stores
                        </div>
                        <div className="flex space-x-2">
                            {stores.current_page > 1 && (
                                <Link
                                    href={`/stores?page=${stores.current_page - 1}`}
                                    className="rounded-lg border border-gray-300 px-3 py-2 text-sm hover:bg-gray-50"
                                >
                                    Previous
                                </Link>
                            )}
                            {stores.current_page < stores.last_page && (
                                <Link
                                    href={`/stores?page=${stores.current_page + 1}`}
                                    className="rounded-lg border border-gray-300 px-3 py-2 text-sm hover:bg-gray-50"
                                >
                                    Next
                                </Link>
                            )}
                        </div>
                    </div>
                )}
            </div>
        </AppShell>
    );
}