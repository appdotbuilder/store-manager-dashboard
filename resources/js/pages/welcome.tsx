import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Store Management Dashboard">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-emerald-50">
                {/* Header */}
                <header className="border-b border-gray-200 bg-white/80 backdrop-blur-sm">
                    <div className="container mx-auto px-6 py-4">
                        <nav className="flex items-center justify-between">
                            <div className="flex items-center space-x-3">
                                <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-white">
                                    <span className="text-xl font-bold">🏪</span>
                                </div>
                                <h1 className="text-xl font-bold text-gray-800">StoreManager Pro</h1>
                            </div>
                            <div className="flex items-center space-x-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                                    >
                                        Go to Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="text-sm font-medium text-gray-600 transition-colors hover:text-blue-600"
                                        >
                                            Sign In
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                                        >
                                            Get Started
                                        </Link>
                                    </>
                                )}
                            </div>
                        </nav>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="container mx-auto px-6 py-20">
                    <div className="text-center">
                        <h1 className="mb-6 text-5xl font-bold text-gray-800">
                            🚀 Multi-Tenant Store Management
                            <span className="block text-blue-600">Made Simple</span>
                        </h1>
                        <p className="mx-auto mb-10 max-w-2xl text-xl text-gray-600">
                            Powerful dashboard application with dual panels for Super Admins and Store Admins. 
                            Manage multiple stores, track sales, handle orders, and grow your business.
                        </p>
                        <div className="flex flex-col items-center justify-center space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                            {!auth.user && (
                                <>
                                    <Link
                                        href={route('register')}
                                        className="w-full rounded-lg bg-blue-600 px-8 py-4 text-lg font-medium text-white transition-colors hover:bg-blue-700 sm:w-auto"
                                    >
                                        Start Free Trial
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="w-full rounded-lg border-2 border-gray-300 px-8 py-4 text-lg font-medium text-gray-700 transition-colors hover:border-blue-600 hover:text-blue-600 sm:w-auto"
                                    >
                                        Sign In
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </section>

                {/* Features Grid */}
                <section className="container mx-auto px-6 py-16">
                    <div className="mb-16 text-center">
                        <h2 className="mb-4 text-3xl font-bold text-gray-800">Everything You Need to Succeed</h2>
                        <p className="text-lg text-gray-600">Professional tools for modern store management</p>
                    </div>
                    
                    <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        {/* Super Admin Features */}
                        <div className="rounded-xl bg-white p-8 shadow-lg border border-gray-100">
                            <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                                <span className="text-2xl">👑</span>
                            </div>
                            <h3 className="mb-3 text-xl font-semibold text-gray-800">Super Admin Panel</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li>• Multi-store dashboard overview</li>
                                <li>• Store management & settings</li>
                                <li>• User permissions & roles</li>
                                <li>• Activity logs & monitoring</li>
                                <li>• Impersonate store admins</li>
                            </ul>
                        </div>

                        {/* Store Admin Features */}
                        <div className="rounded-xl bg-white p-8 shadow-lg border border-gray-100">
                            <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-100">
                                <span className="text-2xl">🏪</span>
                            </div>
                            <h3 className="mb-3 text-xl font-semibold text-gray-800">Store Admin Panel</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li>• Revenue & sales analytics</li>
                                <li>• Product & inventory management</li>
                                <li>• Order processing & tracking</li>
                                <li>• Customer relationship tools</li>
                                <li>• Marketing notifications</li>
                            </ul>
                        </div>

                        {/* Business Features */}
                        <div className="rounded-xl bg-white p-8 shadow-lg border border-gray-100">
                            <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100">
                                <span className="text-2xl">📊</span>
                            </div>
                            <h3 className="mb-3 text-xl font-semibold text-gray-800">Business Intelligence</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li>• Sales reports & analytics</li>
                                <li>• Stock level monitoring</li>
                                <li>• Customer behavior insights</li>
                                <li>• Payment method tracking</li>
                                <li>• Export to Excel/PDF</li>
                            </ul>
                        </div>

                        {/* Order Management */}
                        <div className="rounded-xl bg-white p-8 shadow-lg border border-gray-100">
                            <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100">
                                <span className="text-2xl">📦</span>
                            </div>
                            <h3 className="mb-3 text-xl font-semibold text-gray-800">Order Management</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li>• Real-time order tracking</li>
                                <li>• Status updates & workflow</li>
                                <li>• Invoice generation</li>
                                <li>• Delivery assignment</li>
                                <li>• Payment processing</li>
                            </ul>
                        </div>

                        {/* Product Catalog */}
                        <div className="rounded-xl bg-white p-8 shadow-lg border border-gray-100">
                            <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-green-100">
                                <span className="text-2xl">🛍️</span>
                            </div>
                            <h3 className="mb-3 text-xl font-semibold text-gray-800">Product Catalog</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li>• Categories & subcategories</li>
                                <li>• Brand management</li>
                                <li>• Inventory rules & limits</li>
                                <li>• Image galleries</li>
                                <li>• SEO optimization</li>
                            </ul>
                        </div>

                        {/* Communication */}
                        <div className="rounded-xl bg-white p-8 shadow-lg border border-gray-100">
                            <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-red-100">
                                <span className="text-2xl">📨</span>
                            </div>
                            <h3 className="mb-3 text-xl font-semibold text-gray-800">Customer Communication</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li>• Multi-channel notifications</li>
                                <li>• Email & SMS campaigns</li>
                                <li>• Scheduled messaging</li>
                                <li>• Customer segmentation</li>
                                <li>• Performance tracking</li>
                            </ul>
                        </div>
                    </div>
                </section>

                {/* Demo Data Section */}
                <section className="bg-gray-50 py-16">
                    <div className="container mx-auto px-6">
                        <div className="text-center">
                            <h2 className="mb-6 text-3xl font-bold text-gray-800">🎯 Ready to Explore?</h2>
                            <p className="mb-8 text-lg text-gray-600">
                                Demo data included: Sample store with products, orders, and customers
                            </p>
                            <div className="grid gap-6 md:grid-cols-4">
                                <div className="rounded-lg bg-white p-6 shadow-md">
                                    <div className="mb-2 text-2xl font-bold text-blue-600">1</div>
                                    <div className="text-sm font-medium text-gray-800">Sample Store</div>
                                    <div className="text-xs text-gray-500">TechHub Electronics</div>
                                </div>
                                <div className="rounded-lg bg-white p-6 shadow-md">
                                    <div className="mb-2 text-2xl font-bold text-emerald-600">5</div>
                                    <div className="text-sm font-medium text-gray-800">Products</div>
                                    <div className="text-xs text-gray-500">With inventory rules</div>
                                </div>
                                <div className="rounded-lg bg-white p-6 shadow-md">
                                    <div className="mb-2 text-2xl font-bold text-purple-600">2</div>
                                    <div className="text-sm font-medium text-gray-800">Orders</div>
                                    <div className="text-xs text-gray-500">Complete & processing</div>
                                </div>
                                <div className="rounded-lg bg-white p-6 shadow-md">
                                    <div className="mb-2 text-2xl font-bold text-orange-600">2</div>
                                    <div className="text-sm font-medium text-gray-800">Notifications</div>
                                    <div className="text-xs text-gray-500">Marketing campaigns</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                <section className="container mx-auto px-6 py-20 text-center">
                    <h2 className="mb-6 text-4xl font-bold text-gray-800">
                        Ready to Transform Your Store Management?
                    </h2>
                    <p className="mx-auto mb-10 max-w-xl text-lg text-gray-600">
                        Join thousands of businesses using our platform to streamline operations and boost sales.
                    </p>
                    {!auth.user && (
                        <Link
                            href={route('register')}
                            className="inline-flex items-center rounded-lg bg-blue-600 px-8 py-4 text-lg font-medium text-white transition-colors hover:bg-blue-700"
                        >
                            Get Started Today
                            <span className="ml-2">→</span>
                        </Link>
                    )}
                </section>

                {/* Footer */}
                <footer className="border-t border-gray-200 bg-gray-50 py-12">
                    <div className="container mx-auto px-6 text-center">
                        <div className="mb-4 flex items-center justify-center space-x-3">
                            <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white">
                                <span className="text-sm font-bold">🏪</span>
                            </div>
                            <span className="font-semibold text-gray-800">StoreManager Pro</span>
                        </div>
                        <p className="text-sm text-gray-600">
                            Built with ❤️ using Laravel + React + TypeScript
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}