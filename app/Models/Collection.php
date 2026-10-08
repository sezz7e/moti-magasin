<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Collection extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile()->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('card')->width(600)->format('webp')->nonQueued();
        $this->addMediaConversion('large')->width(1400)->format('webp')->nonQueued();
    }

    /**
     * The collection's own cover image, or the newest product's photo if no cover is uploaded.
     */
    public function coverUrl(string $conversion = 'card'): ?string
    {
        $url = $this->getFirstMediaUrl('cover', $conversion);

        if ($url) {
            return $url;
        }

        $product = $this->relationLoaded('products')
            ? $this->products->first()
            : $this->products()->where('is_active', true)->latest()->first();

        return $product?->getFirstMediaUrl('gallery', $conversion) ?: null;
    }
}