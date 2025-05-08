<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'address', 'gender', 
        'phone', 'role', 'is_member', 'password'
    ];

  
    public function membership()
    {
        return $this->hasOne(Membership::class)->withDefault([
            'start_date' => null,
            'end_date' => null,
            'status' => 'inactive',
        
        ]);
    }
    
    // Untuk akses langsung ke membership type
    public function membershipType()
    {
        return $this->hasOneThrough(
            MembershipType::class,
            Membership::class,
            'user_id', // Foreign key di tabel memberships
            'id',      // Foreign key di tabel membership_types
            'id',      // Local key di tabel users
            'membership_type' // Local key di tabel memberships
        );
    }



    public function isAdmin()
    {
        return $this->role === 'admin';
    }

}

