<?php

namespace Database\Seeders;

use App\Models\Products\Product;
use App\Models\Sales\SaleHeader;
use App\Models\Store\ProductInput;
use App\Models\Store\ProductInputHeader;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\PaymentType;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $data = require 'data/products.php';
        Product::factory()->createMany($data);
    }

}
