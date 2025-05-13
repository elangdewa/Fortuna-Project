<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalTrainerOrder extends Model
{
    public $timestamps = false; // Nonaktifkan timestamp
    use HasFactory;
 


    protected $fillable = ['user_id', 'trainer_id', 'order_date', 'notes', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(PersonalTrainer::class, 'trainer_id');
    }

    public function personalTrainerOrders()
{
    return $this->hasMany(PersonalTrainerOrder::class);
}

}
