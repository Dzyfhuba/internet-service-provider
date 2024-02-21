<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 11) as $value) {
            Product::create([
                'product_name' => 5 * pow($value, 2) . " Mbps",
                'product_description' => 5 * pow($value, 2) . " Mbps",
                'product_price_capital' => round((9 * pow($value, 2) * 10000) / ($value * 1.1), -3),
                'product_price_sell' => round((9 * pow($value, 2) * 1.05 * 10000) / ($value * 1.1), -3),
            ]);
        }
    }
}
