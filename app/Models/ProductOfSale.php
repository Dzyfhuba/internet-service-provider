<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOfSale extends Model
{
    use HasFactory;

    protected $table = 'product_sales';

    protected $fillable = [
        'product_id'
    ];

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}