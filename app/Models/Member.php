<?php
// filepath: app\Models\Member.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'memberships';
    protected $fillable = [
        'name',
        'email',
        'address',
        'gender',
        'phone',
        'password',
        'role',
        'is_member',
        'membership_type_id',
        'membership_start_date',
        'membership_end_date'
    ];
}