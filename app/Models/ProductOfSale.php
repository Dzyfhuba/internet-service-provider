<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOfSale extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_sales';

    protected $fillable = [
        'product_name',
        'final_price_capital',
        'final_price_sell',
    ];
}
