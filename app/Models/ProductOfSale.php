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
        'product_id',
        'final_price_capital',
        'final_price_sell',
    ];

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $product = Product::find($model->product_id);
            $model->final_price_capital = $product->product_price_capital;
            $model->final_price_sell = $product->product_price_sell;
        });
    }

}
