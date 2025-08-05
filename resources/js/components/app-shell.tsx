import { SidebarProvider } from '@/components/ui/sidebar';
import { SharedData } from '@/types';
import { Link, router, usePage } from '@inertiajs/react';

interface AppShellProps {
    children: React.ReactNode;
    variant?: 'header' | 'sidebar';
}

export function AppShell({ children, variant = 'sidebar' }: AppShellProps) {
    const { auth } = usePage<SharedData>().props;
    const isOpen = usePage<SharedData>().props.sidebarOpen;

    const handleLogout = () => {
        router.post('/logout');
    };

    if (variant === 'header') {
        return <div className="flex min-h-screen w-full flex-col">{children}</div>;
    }

    return (
        <SidebarProvider defaultOpen={isOpen}>
            <div className="flex min-h-screen w-full">
                {/* Sidebar */}
                <div className="w-64 border-r border-gray-200 bg-white">
                    <div className="flex h-16 items-center border-b border-gray-200 px-6">
                        <div className="flex items-center space-x-3">
                            <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white">
                                <span className="text-sm font-bold">🏪</span>
                            </div>
                            <h1 className="text-lg font-semibold text-gray-800">StoreManager</h1>
                        </div>
                    </div>
                    
                    <nav className="p-4">
                        <div className="space-y-2">
                            <Link
                                href="/dashboard"
                                className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                            >
                                <span className="mr-3">📊</span>
                                Dashboard
                            </Link>
                            
                            {auth.user?.role === 'super_admin' && (
                                <>
                                    <Link
                                        href="/stores"
                                        className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    >
                                        <span className="mr-3">🏪</span>
                                        Stores
                                    </Link>
                                    <Link
                                        href="/users"
                                        className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    >
                                        <span className="mr-3">👥</span>
                                        Users & Permissions
                                    </Link>
                                    <Link
                                        href="/activity-logs"
                                        className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    >
                                        <span className="mr-3">📋</span>
                                        Activity Logs
                                    </Link>
                                </>
                            )}

                            {auth.user?.role === 'store_admin' && (
                                <>
                                    <Link
                                        href="/store/info"
                                        className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    >
                                        <span className="mr-3">🏪</span>
                                        Store Info
                                    </Link>
                                    <Link
                                        href="/products"
                                        className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    >
                                        <span className="mr-3">📦</span>
                                        Products
                                    </Link>
                                    <Link
                                        href="/orders"
                                        className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    >
                                        <span className="mr-3">📋</span>
                                        Orders
                                    </Link>
                                    <Link
                                        href="/customers"
                                        className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    >
                                        <span className="mr-3">👥</span>
                                        Customers
                                    </Link>
                                    <Link
                                        href="/notifications"
                                        className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    >
                                        <span className="mr-3">📨</span>
                                        Notifications
                                    </Link>
                                    <Link
                                        href="/reports"
                                        className="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    >
                                        <span className="mr-3">📊</span>
                                        Reports
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </div>

                {/* Main Content */}
                <div className="flex-1">
                    {/* Top Header */}
                    <div className="border-b border-gray-200 bg-white">
                        <div className="flex h-16 items-center justify-between px-6">
                            <div></div> {/* Spacer */}
                            <div className="flex items-center space-x-4">
                                {/* User Menu */}
                                <div className="flex items-center space-x-3">
                                    <div className="text-right">
                                        <p className="text-sm font-medium text-gray-800">{auth.user?.name}</p>
                                        <p className="text-xs text-gray-500 capitalize">{auth.user?.role?.split('_').join(' ')}</p>
                                    </div>
                                    <button
                                        onClick={handleLogout}
                                        className="rounded-lg border border-gray-300 px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50"
                                    >
                                        Sign Out
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Page Content */}
                    <div className="p-6">
                        {children}
                    </div>
                </div>
            </div>
        </SidebarProvider>
    );
}
