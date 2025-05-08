<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    public $timestamps = true; 
    protected $fillable = [
        'user_id', 'membership_type', 'price', 'status',
        'start_date', 'end_date', 'payment_status'
    ];


    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(MembershipType::class, 'membership_type');
    }
}
