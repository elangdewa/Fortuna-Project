<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration_in_months',
    ];

    /**
     * Get the members that belong to this membership type.
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'membership_type_id');
    }
}