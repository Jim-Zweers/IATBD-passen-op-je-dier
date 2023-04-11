<?php

namespace App\Models;

use App\Enums\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'owner_id',
    ];

    protected $casts = [
        'type' => Type::class,
    ];

    public function images(): HasMany{
        return $this->hasMany(Image::class, 'pet_id');
    }

    public function requests(): HasMany{
        return $this->hasMany(Request::class, 'pet_id');
    }
}
