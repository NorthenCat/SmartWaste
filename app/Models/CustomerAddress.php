<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $table = 'customer_address';
    protected $fillable = [
        'uuid',
        'customer_id',
        'location_name',
        'location_address',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
