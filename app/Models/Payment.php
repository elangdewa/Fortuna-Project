<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'membership_id',
        'type',
        'payment_method',
        'payment_status',
        'transaction_id',
        'amount',
        'payment_time',
        'reference_id'
    ];

    protected $casts = [
        'payment_time' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class);
    }

}
