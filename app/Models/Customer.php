<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';

    protected $fillable = [
        'uuid',
        'user_id',
        'full_name',
        'email',
        'point'
    ];

    public function customerPromo()
    {
        return $this->hasMany(CustomerPromo::class, 'customer_id', 'id');
    }
}
