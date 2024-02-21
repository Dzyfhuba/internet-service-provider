<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointOfSale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_name',
        'final_price_capital',
        'final_price_sell',
    ];
}
