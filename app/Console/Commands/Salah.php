<?php

namespace App\Console\Commands;

use App\Models\Products\MeasureUnit;
use App\Models\Products\Product;
use Illuminate\Console\Command;

class Salah extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:salah';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
//        foreach (MeasureUnit::all() as $unit) {
//            if ($unit->isCost()){
//                $unit->update([
//                    'cost_price'=>$unit->cost->unit_cost_price,
//                    'is_cost'=>true
//                ]);
//            }
//        }
        foreach (Product::all() as $product) {
            if ($product->lastStoreItem()->exists()){
                $product->update([
                    'cost_price' => $product->lastStoreItem->unit_cost_price,
                ]);
            }
        }
    }
}
