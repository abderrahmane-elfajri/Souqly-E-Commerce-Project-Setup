<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sku',
        'slug',
        'price',
        'compare_at_price',
        'stock',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'stock' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function translation(?string $locale = null): ?ProductTranslation
    {
        $locale = $locale ?: App::getLocale();
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', config('app.fallback_locale', 'en'))
            ?? $this->translations->first();
    }

    public function getNameAttribute(): string
    {
        return $this->translation()?->name ?? $this->sku;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        return $this->translation()?->short_description;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->translation()?->description;
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        return $this->primaryImage?->image_path 
            ?? $this->images->first()?->image_path 
            ?? $this->defaultImageFallback();
    }

    public function defaultImageFallback(): string
    {
        return match($this->slug) {
            'souqly-royal-chrono-41mm' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=85',
            'souqly-heritage-classic-gold' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&w=1200&q=85',
            'souqly-air-pro-anc' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=1200&q=85',
            'souqly-smart-titanium-ultra' => 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?auto=format&fit=crop&w=1200&q=85',
            'sac-cuir-marocain-artisan' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=1200&q=85',
            'service-tajine-design-contemporain' => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?auto=format&fit=crop&w=1200&q=85',
            default => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1200&q=85',
        };
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->compare_at_price && $this->compare_at_price > $this->price) {
            return (int) round((($this->compare_at_price - $this->price) / $this->compare_at_price) * 100);
        }
        return null;
    }

    public function isInStock(): bool
    {
        return $this->stock > 0 || $this->variants->sum('stock') > 0;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // Category filter
        if (! empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        // Min price
        if (! empty($filters['min_price'])) {
            $query->where('price', '>=', (float) $filters['min_price']);
        }

        // Max price
        if (! empty($filters['max_price'])) {
            $query->where('price', '<=', (float) $filters['max_price']);
        }

        // Keyword Search across translations and sku
        if (! empty($filters['q'])) {
            $term = '%' . $filters['q'] . '%';
            $query->where(function ($sub) use ($term) {
                $sub->where('sku', 'like', $term)
                    ->orWhereHas('translations', function ($t) use ($term) {
                        $t->where('name', 'like', $term)
                          ->orWhere('short_description', 'like', $term)
                          ->orWhere('description', 'like', $term);
                    });
            });
        }

        // Sorting
        return match ($filters['sort'] ?? 'latest') {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('sku', 'asc'), // fallback sort
            default => $query->latest(),
        };
    }
}
