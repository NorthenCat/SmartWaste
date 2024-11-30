<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = "promo_point";
    protected $fillable = ['uuid', 'name', 'point_price', 'multiply_point', 'type_transaction', 'note', 'type_promo', 'discount'];


}
