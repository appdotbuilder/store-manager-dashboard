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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('total_spent', 10, 2)->default(0);
            $table->integer('total_orders')->default(0);
            $table->timestamp('last_order_at')->nullable();
            $table->timestamps();
            
            $table->unique(['store_id', 'phone']);
            $table->index(['store_id', 'email']);
            $table->index(['store_id', 'is_active']);
            $table->index(['store_id', 'total_spent']);
            $table->index(['store_id', 'total_orders']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};