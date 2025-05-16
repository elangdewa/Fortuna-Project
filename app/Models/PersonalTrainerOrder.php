<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalTrainerOrder extends Model
{
    public $timestamps = false; // Nonaktifkan timestamp
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trainer_id',
        'order_date',
        'notes',
        'status',
        'sessions',
        'payment_status',
        'total_price',
        'expires_at'
    ];

     protected $dates = [
        'order_date',
        'expires_at'
    ];

     protected $casts = [
        'total_price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(PersonalTrainer::class, 'trainer_id');
    }



}
