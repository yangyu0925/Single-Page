<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        foreach (range(10, 65) as $i) {
            Product::create([
                'item_code' => 'PDT-1000'.$i,
                'description' => 'Name of Product'.$i,
                'unit_price' => mt_rand(100, 1000)
            ]);
        }
    }
}
