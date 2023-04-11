<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'till',
        'pet_id',
        'owner_id',
        'sitter_id',
        'hourly_rate',
    ];

    public function pet(): BelongsTo {
        return $this->belongsTo(Pet::class);
    }

    public function sitter(): BelongsTo {
        return $this->belongsTo(User::class, 'sitter_id');
    }

    public function review(): HasOne {
        return $this->hasOne(Review::class, 'request_id');
    }
}
