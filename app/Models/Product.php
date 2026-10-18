<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'metals' => 'array',
        'stone_colors' => 'array',
        'sizes' => 'array',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('card')->width(600)->format('webp')->nonQueued();
        $this->addMediaConversion('large')->width(1400)->format('webp')->nonQueued();
    }

    public function optionGroups(): array
{
    $groups = [];

    foreach ([
        'metal' => ['label' => 'Metal', 'values' => $this->metals],
        'stone' => ['label' => 'Colour', 'values' => $this->stone_colors],
        'size' => ['label' => 'Size', 'values' => $this->sizes],
    ] as $key => $group) {
        $values = array_values(array_filter(array_map('strval', (array) $group['values']), fn ($v) => $v !== ''));

        if ($values) {
            $groups[$key] = ['label' => $group['label'], 'values' => $values];
        }
    }

    return $groups;
}

public function needsOptions(): bool
{
    foreach ($this->optionGroups() as $group) {
        if (count($group['values']) > 1) {
            return true;
        }
    }

    return false;
}
}