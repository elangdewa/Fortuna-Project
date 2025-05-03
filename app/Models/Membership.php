<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_type',
        'status',
        'start_date',
        'end_date',
        'payment_status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke MembershipType
    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class, 'membership_type');
    }
}
