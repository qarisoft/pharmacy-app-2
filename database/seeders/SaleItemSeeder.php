<?php

namespace Database\Seeders;

use App\Models\Activities\CreatedBy;
use App\Models\Products\Company;
use App\Models\Products\MeasureUnit;
use App\Models\Products\MeasureUnitName;
use App\Models\Products\Product;
use App\Models\Refund\ReturnHeader;
use App\Models\Refund\ReturnItem;
use App\Models\Refund\WithDraw;
use App\Models\Sales\SaleHeader;
use App\Models\Sales\SaleItem;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleItemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $headers = require 'data/sales/sale_headers.php';
        if (file_exists('data/sales/sale_headers.php')) {
            SaleHeader::factory()->createMany($headers);
        }
        $items = require 'data/sales/sale_items.php';
        if (file_exists('data/sales/sale_items.php')) {
            SaleItem::factory()->createMany($items);
        }


        if (file_exists('data/sales/return_headers.php')) {
            $returns = require 'data/sales/return_headers.php';
            ReturnHeader::factory()->createMany($returns);
        }

        if (file_exists('data/sales/return_items.php')) {
            $items = require 'data/sales/return_items.php';
            ReturnItem::factory()->createMany($items);
        }

        if (file_exists('data/sales/with_draws.php')) {
            $with_draws = require 'data/sales/with_draws.php';
            WithDraw::factory()->createMany($with_draws);
        }
        if (file_exists('data/sales/created_by.php')) {
            $created_by = require 'data/sales/created_by.php';
            CreatedBy::factory()->createMany($created_by);
        }

    }

}
