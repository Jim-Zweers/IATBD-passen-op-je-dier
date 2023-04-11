<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'description'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => Role::class,
    ];

    public function pets(): HasMany {
        return $this->hasMany(Pet::class, 'owner_id');
    }

    public function requests(): HasMany {
        return $this->hasMany(Request::class, 'owner_id');
    }

    public function images(): HasMany{
        return $this->hasMany(Image::class, 'user_id');
    }

    public function reviews(): HasManyThrough {
        return $this->hasManyThrough(Review::class, Request::class, 'sitter_id', 'request_id', 'id', 'id');
    }

    public function getRedirectRoute()
    {

        if($this->role == Role::Owner->value){
            return 'dieren';
        }elseif($this->role == Role::Sitter->value){
            return 'sitter.edit';
        }elseif($this->role == Role::Admin->value){
            return 'animals.index';
        }

        return 'dieren';
    }
}
