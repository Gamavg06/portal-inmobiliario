<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'property_id',
    'user_id',
    'message'
])]
class Lead extends Model
{
    use HasFactory;

    /**
     * Disable the updated_at timestamp.
     */
    const UPDATED_AT = null;

    /**
     * Get the property associated with the lead.
     */
    public function property(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user (buyer) who created the lead.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
