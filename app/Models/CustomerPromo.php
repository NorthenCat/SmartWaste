<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPromo extends Model
{
    protected $table = "customer_promo";
    protected $fillable = ['customer_id', 'promo_id', 'valid'];

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'promo_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
