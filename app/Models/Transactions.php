<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'uuid',
        'customer_id',
        'product_name',
        'quantity',
        'unit',
        'total_price',
        'status',
        'address',
        'type',
        'bonus_point',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }


}
