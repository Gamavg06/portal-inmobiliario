<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'property_id',
    'image_path'
])]
class PropertyImage extends Model
{
    use HasFactory;

    /**
     * Get the property that owns the image.
     */
    public function property(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get full image URL.
     */
    public function getUrlAttribute(): string
    {
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }
        return asset('storage/' . $this->image_path);
    }
}
