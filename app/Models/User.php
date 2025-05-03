<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'address',
        'gender',
        'phone',
        'role',
        'is_member',
        'membership_type_id',
        'password',
        'join_date',
        'expire_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function membershipType()
    {
        return $this->belongsTo(\App\Models\MembershipType::class, 'membership_type_id');
    }

    public function membership()
    {
        return $this->hasOne(Membership::class);
    }
    
    public function isAdmin()
{
    return $this->role === 'admin';
}
}

