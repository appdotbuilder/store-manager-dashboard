<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $store_id
 * @property string|null $sku
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $short_description
 * @property array|null $images
 * @property int|null $category_id
 * @property int|null $brand_id
 * @property int $stock_quantity
 * @property float $price
 * @property float|null $discount_price
 * @property int $minimum_quantity
 * @property int|null $maximum_per_order
 * @property string|null $expiry_date
 * @property bool $is_available
 * @property bool $is_featured
 * @property bool $is_visible
 * @property array|null $tags
 * @property array|null $attributes
 * @property int $views_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Store $store
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Brand|null $brand
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product available()
 * @method static \Illuminate\Database\Eloquent\Builder|Product featured()
 * @method static \Illuminate\Database\Eloquent\Builder|Product visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Product lowStock($threshold = 10)
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'store_id',
        'sku',
        'name',
        'slug',
        'description',
        'short_description',
        'images',
        'category_id',
        'brand_id',
        'stock_quantity',
        'price',
        'discount_price',
        'minimum_quantity',
        'maximum_per_order',
        'expiry_date',
        'is_available',
        'is_featured',
        'is_visible',
        'tags',
        'attributes',
        'views_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
        'attributes' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'minimum_quantity' => 'integer',
        'maximum_per_order' => 'integer',
        'views_count' => 'integer',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'is_visible' => 'boolean',
        'expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the store that owns the product.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to only include available products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope a query to only include featured products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include visible products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope a query to only include low stock products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $threshold
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock_quantity', '<=', $threshold);
    }

    /**
     * Get the effective price (discount price if available, otherwise regular price).
     */
    public function getEffectivePriceAttribute(): float
    {
        return $this->discount_price ?? $this->price;
    }
}