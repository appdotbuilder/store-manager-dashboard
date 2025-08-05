<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StoreManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@storemanager.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Create a sample store
        $store = Store::create([
            'name' => 'TechHub Electronics',
            'slug' => 'techhub-electronics',
            'description' => 'Your one-stop shop for the latest electronics and gadgets. We offer premium quality products with excellent customer service.',
            'phone' => '+1-555-0123',
            'whatsapp' => '+1-555-0123',
            'email' => 'info@techhub.com',
            'website' => 'https://techhub.com',
            'address' => '123 Tech Street, Silicon Valley, CA 94043',
            'latitude' => 37.4419,
            'longitude' => -122.1430,
            'business_hours' => [
                'monday' => ['open' => '09:00', 'close' => '18:00'],
                'tuesday' => ['open' => '09:00', 'close' => '18:00'],
                'wednesday' => ['open' => '09:00', 'close' => '18:00'],
                'thursday' => ['open' => '09:00', 'close' => '18:00'],
                'friday' => ['open' => '09:00', 'close' => '18:00'],
                'saturday' => ['open' => '10:00', 'close' => '16:00'],
                'sunday' => ['open' => '12:00', 'close' => '15:00'],
            ],
            'delivery_areas' => [
                ['name' => 'Downtown', 'fee' => 5.00],
                ['name' => 'Suburbs', 'fee' => 8.00],
                ['name' => 'Extended Area', 'fee' => 12.00],
            ],
            'default_delivery_fee' => 8.00,
            'currency' => 'USD',
            'timezone' => 'America/Los_Angeles',
            'theme' => 'light',
            'vat_percentage' => 8.25,
            'payment_methods' => [
                'cod' => ['enabled' => true, 'name' => 'Cash on Delivery'],
                'bank_transfer' => ['enabled' => true, 'name' => 'Bank Transfer', 'details' => 'Account: 123456789'],
                'credit_card' => ['enabled' => true, 'name' => 'Credit Card'],
            ],
            'settings' => [
                'coupons_enabled' => true,
                'wishlists_enabled' => true,
                'reviews_enabled' => true,
                'min_order_amount' => 25.00,
                'max_order_amount' => 5000.00,
                'auto_approve_orders' => false,
            ],
            'is_active' => true,
        ]);

        // Create Store Admin
        $storeAdmin = User::create([
            'name' => 'Store Manager',
            'email' => 'manager@techhub.com',
            'password' => Hash::make('password'),
            'role' => 'store_admin',
            'store_id' => $store->id,
            'is_active' => true,
            'permissions' => [
                'manage_products' => true,
                'manage_orders' => true,
                'manage_customers' => true,
                'view_reports' => true,
                'send_notifications' => true,
            ],
        ]);

        // Create categories
        $categories = [
            ['name' => 'Smartphones', 'description' => 'Latest smartphones and mobile devices'],
            ['name' => 'Laptops', 'description' => 'Professional and gaming laptops'],
            ['name' => 'Accessories', 'description' => 'Tech accessories and peripherals'],
        ];

        $createdCategories = [];
        foreach ($categories as $categoryData) {
            $category = Category::create([
                'store_id' => $store->id,
                'name' => $categoryData['name'],
                'slug' => strtolower(str_replace(' ', '-', $categoryData['name'])),
                'description' => $categoryData['description'],
                'sort_order' => count($createdCategories) + 1,
                'is_active' => true,
            ]);
            $createdCategories[] = $category;
        }

        // Create subcategories
        $subcategories = [
            ['name' => 'iPhone', 'parent_id' => $createdCategories[0]->id],
            ['name' => 'Android', 'parent_id' => $createdCategories[0]->id],
            ['name' => 'Gaming Laptops', 'parent_id' => $createdCategories[1]->id],
        ];

        foreach ($subcategories as $subcategoryData) {
            Category::create([
                'store_id' => $store->id,
                'name' => $subcategoryData['name'],
                'slug' => strtolower(str_replace(' ', '-', $subcategoryData['name'])),
                'parent_id' => $subcategoryData['parent_id'],
                'sort_order' => 1,
                'is_active' => true,
            ]);
        }

        // Create brands
        $brands = [
            ['name' => 'Apple', 'description' => 'Premium technology products'],
            ['name' => 'Samsung', 'description' => 'Innovative electronics and mobile devices'],
            ['name' => 'Dell', 'description' => 'Professional computing solutions'],
        ];

        $createdBrands = [];
        foreach ($brands as $brandData) {
            $brand = Brand::create([
                'store_id' => $store->id,
                'name' => $brandData['name'],
                'slug' => strtolower($brandData['name']),
                'description' => $brandData['description'],
                'is_active' => true,
            ]);
            $createdBrands[] = $brand;
        }

        // Create products with rules
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'The most advanced iPhone yet with titanium design, A17 Pro chip, and professional camera system.',
                'category_id' => $createdCategories[0]->id,
                'brand_id' => $createdBrands[0]->id,
                'price' => 999.00,
                'discount_price' => 949.00,
                'stock_quantity' => 25,
                'minimum_quantity' => 1,
                'maximum_per_order' => 2,
                'is_featured' => true,
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Flagship Android smartphone with S Pen, advanced AI features, and exceptional camera capabilities.',
                'category_id' => $createdCategories[0]->id,
                'brand_id' => $createdBrands[1]->id,
                'price' => 1199.00,
                'stock_quantity' => 18,
                'minimum_quantity' => 1,
                'maximum_per_order' => 2,
                'is_featured' => true,
            ],
            [
                'name' => 'Dell XPS 15',
                'description' => 'Premium laptop with InfinityEdge display, powerful performance for professionals and creators.',
                'category_id' => $createdCategories[1]->id,
                'brand_id' => $createdBrands[2]->id,
                'price' => 1499.00,
                'discount_price' => 1399.00,
                'stock_quantity' => 12,
                'minimum_quantity' => 1,
                'maximum_per_order' => 1,
                'is_featured' => false,
            ],
            [
                'name' => 'Apple AirPods Pro',
                'description' => 'Wireless earbuds with active noise cancellation, spatial audio, and premium sound quality.',
                'category_id' => $createdCategories[2]->id,
                'brand_id' => $createdBrands[0]->id,
                'price' => 249.00,
                'stock_quantity' => 45,
                'minimum_quantity' => 1,
                'maximum_per_order' => 3,
                'is_featured' => false,
            ],
            [
                'name' => 'Samsung 27" Monitor',
                'description' => '4K UHD monitor with HDR support, perfect for gaming and professional work.',
                'category_id' => $createdCategories[2]->id,
                'brand_id' => $createdBrands[1]->id,
                'price' => 329.00,
                'stock_quantity' => 8,
                'minimum_quantity' => 1,
                'maximum_per_order' => 2,
                'is_featured' => false,
            ],
        ];

        $createdProducts = [];
        foreach ($products as $productData) {
            $product = Product::create([
                'store_id' => $store->id,
                'sku' => 'SKU-' . strtoupper(substr(hash('sha256', $productData['name']), 0, 8)),
                'name' => $productData['name'],
                'slug' => strtolower(str_replace(' ', '-', $productData['name'])),
                'description' => $productData['description'],
                'short_description' => substr($productData['description'], 0, 150) . '...',
                'images' => [
                    'https://via.placeholder.com/400x400/0066cc/ffffff?text=' . urlencode($productData['name']),
                    'https://via.placeholder.com/400x400/10b981/ffffff?text=' . urlencode('Photo 2'),
                ],
                'category_id' => $productData['category_id'],
                'brand_id' => $productData['brand_id'],
                'stock_quantity' => $productData['stock_quantity'],
                'price' => $productData['price'],
                'discount_price' => $productData['discount_price'] ?? null,
                'minimum_quantity' => $productData['minimum_quantity'],
                'maximum_per_order' => $productData['maximum_per_order'],
                'expiry_date' => null,
                'is_available' => true,
                'is_featured' => $productData['is_featured'],
                'is_visible' => true,
                'tags' => ['electronics', 'popular', 'new'],
                'attributes' => [
                    'warranty' => '1 year',
                    'color' => 'Multiple colors available',
                    'condition' => 'New',
                ],
                'views_count' => random_int(50, 500),
            ]);
            $createdProducts[] = $product;
        }

        // Create customers
        $customers = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'phone' => '+1-555-0101',
                'address' => '456 Customer Lane, Tech City, CA 94044',
                'total_spent' => 1248.00,
                'total_orders' => 3,
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@email.com',
                'phone' => '+1-555-0102',
                'address' => '789 Buyer Street, Innovation District, CA 94045',
                'total_spent' => 599.00,
                'total_orders' => 1,
            ],
        ];

        $createdCustomers = [];
        foreach ($customers as $customerData) {
            $customer = Customer::create([
                'store_id' => $store->id,
                'name' => $customerData['name'],
                'email' => $customerData['email'],
                'phone' => $customerData['phone'],
                'address' => $customerData['address'],
                'latitude' => 37.4419 + (random_int(-100, 100) / 10000),
                'longitude' => -122.1430 + (random_int(-100, 100) / 10000),
                'is_active' => true,
                'total_spent' => $customerData['total_spent'],
                'total_orders' => $customerData['total_orders'],
                'last_order_at' => now()->subDays(random_int(1, 30)),
            ]);
            $createdCustomers[] = $customer;
        }

        // Create orders
        $orders = [
            [
                'customer_id' => $createdCustomers[0]->id,
                'status' => 'completed',
                'payment_status' => 'paid',
                'subtotal' => 949.00,
                'items' => [
                    ['product_id' => $createdProducts[0]->id, 'quantity' => 1, 'unit_price' => 949.00],
                ],
            ],
            [
                'customer_id' => $createdCustomers[1]->id,
                'status' => 'processing',
                'payment_status' => 'paid',
                'subtotal' => 578.00,
                'items' => [
                    ['product_id' => $createdProducts[3]->id, 'quantity' => 1, 'unit_price' => 249.00],
                    ['product_id' => $createdProducts[4]->id, 'quantity' => 1, 'unit_price' => 329.00],
                ],
            ],
        ];

        foreach ($orders as $orderData) {
            $taxAmount = $orderData['subtotal'] * 0.0825; // 8.25% tax
            $deliveryFee = 8.00;
            $totalAmount = $orderData['subtotal'] + $taxAmount + $deliveryFee;

            $order = Order::create([
                'store_id' => $store->id,
                'order_number' => 'TH-' . str_pad((string) random_int(1, 9999), 6, '0', STR_PAD_LEFT),
                'customer_id' => $orderData['customer_id'],
                'status' => $orderData['status'],
                'subtotal' => $orderData['subtotal'],
                'tax_amount' => $taxAmount,
                'delivery_fee' => $deliveryFee,
                'discount_amount' => 0,
                'total_amount' => $totalAmount,
                'payment_method' => 'credit_card',
                'payment_status' => $orderData['payment_status'],
                'delivery_address' => collect($createdCustomers)->where('id', $orderData['customer_id'])->first()->address,
                'delivery_phone' => collect($createdCustomers)->where('id', $orderData['customer_id'])->first()->phone,
                'assigned_to' => $storeAdmin->id,
                'delivered_at' => $orderData['status'] === 'completed' ? now()->subDays(2) : null,
            ]);

            // Create order items
            foreach ($orderData['items'] as $itemData) {
                $product = collect($createdProducts)->where('id', $itemData['product_id'])->first();
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $itemData['quantity'] * $itemData['unit_price'],
                    'product_snapshot' => [
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $product->images[0] ?? null,
                    ],
                ]);
            }
        }

        // Create notifications
        $notifications = [
            [
                'title' => '🎉 New Product Launch: iPhone 15 Pro',
                'message' => 'Discover the most advanced iPhone yet! Now available with special launch pricing. Limited time offer - get yours today!',
                'status' => 'sent',
                'sent_count' => 156,
                'opened_count' => 89,
                'clicked_count' => 23,
            ],
            [
                'title' => '📱 Back in Stock: Samsung Galaxy S24 Ultra',
                'message' => 'Good news! The Samsung Galaxy S24 Ultra is back in stock. Order now before it sells out again!',
                'status' => 'scheduled',
                'scheduled_at' => now()->addHours(2),
            ],
        ];

        foreach ($notifications as $notificationData) {
            Notification::create([
                'store_id' => $store->id,
                'title' => $notificationData['title'],
                'message' => $notificationData['message'],
                'channels' => ['app', 'email'],
                'target_audience' => [
                    'type' => 'all',
                    'criteria' => 'active_customers',
                ],
                'status' => $notificationData['status'],
                'scheduled_at' => $notificationData['scheduled_at'] ?? null,
                'sent_at' => $notificationData['status'] === 'sent' ? now()->subHours(24) : null,
                'sent_count' => $notificationData['sent_count'] ?? 0,
                'opened_count' => $notificationData['opened_count'] ?? 0,
                'clicked_count' => $notificationData['clicked_count'] ?? 0,
                'created_by' => $storeAdmin->id,
            ]);
        }

        // Create some activity logs
        $activities = [
            'Super Admin logged in',
            'Store Manager created new product: iPhone 15 Pro',
            'Order #TH-000001 was completed',
            'Customer John Smith registered',
            'Notification sent to 156 customers',
            'Product inventory updated',
            'Store settings modified',
            'New order received from Sarah Johnson',
        ];

        foreach ($activities as $activity) {
            ActivityLog::create([
                'store_id' => $store->id,
                'user_id' => random_int(0, 1) ? $superAdmin->id : $storeAdmin->id,
                'action' => strtolower(explode(' ', $activity)[0]),
                'description' => $activity,
                'properties' => [
                    'timestamp' => now()->subHours(random_int(1, 48)),
                ],
                'ip_address' => '192.168.1.' . random_int(1, 255),
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ]);
        }
    }
}