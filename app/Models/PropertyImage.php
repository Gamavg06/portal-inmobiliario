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

        $cleanPath = ltrim($this->image_path, '/');
        $publicPath = public_path('storage/' . $cleanPath);

        if (file_exists($publicPath)) {
            return asset('storage/' . $cleanPath);
        }

        // High quality fallback image if local file is missing on Cloud9 server
        return 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80';
    }
}
