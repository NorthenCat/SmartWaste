<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = [
        'uuid',
        'user_id',
        'full_name',
        'email',
        'points'
    ];
}
