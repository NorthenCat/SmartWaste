<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'uuid',
        'name',
        'price_per_unit',
        'price_sell_per_unit',
        'unit',
        'weight_for_point',
        'point_per_weight',
        'minimal_weight',
        'minimal_sell_weight',
        'stock',
        'stock_unit',
        'image'
    ];
}
