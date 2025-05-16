<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'address', 'gender',
        'phone', 'role', 'is_member', 'password','profile_photo',
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
            'user_id',
            'id',
            'id',
            'membership_type'
        );
    }



    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasFreeFitnessClassAccess()
{
    $membership = $this->membership;

    return $membership &&
           $membership->membership_type === 4 && // misal ID 4 adalah 12 bulan
           $membership->status === 'active' &&
           $membership->payment_status === 'paid';
}

}

