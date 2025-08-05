<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->json('images')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('stock_quantity')->default(0);
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('minimum_quantity')->default(1);
            $table->integer('maximum_per_order')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->json('tags')->nullable();
            $table->json('attributes')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();
            
            $table->unique(['store_id', 'sku']);
            $table->unique(['store_id', 'slug']);
            $table->index(['store_id', 'is_available', 'is_visible']);
            $table->index(['store_id', 'category_id']);
            $table->index(['store_id', 'brand_id']);
            $table->index(['store_id', 'is_featured']);
            $table->index(['store_id', 'stock_quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};