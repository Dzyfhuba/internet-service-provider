<?php

namespace Database\Seeders;

use App\Models\PointOfSale;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PointOfSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(0, 1000) as $value) {
            $product = Product::inRandomOrder()->first();
            PointOfSale::create([
                'product_name' => $product->product_name,
                'final_price_capital' => $product->product_price_capital,
                'final_price_sell' => $product->product_price_sell,
                'quantity' => random_int(1, 10)
            ]);
        }
    }
}
