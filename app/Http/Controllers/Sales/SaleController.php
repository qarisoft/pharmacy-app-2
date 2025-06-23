<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Products\MeasureUnit;
use App\Models\Products\Product;
use App\Models\Sales\SaleHeader;
use App\Models\Sales\SaleItem;
use App\Models\Sales\Sheft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $q=SaleHeader::query();
        // if (Cache::has('sheft')){
        //     $q=$q->whereBelongsTo(Cache::get('sheft'));
        // }
        $q2=$q;
        return inertia('sales/index', [
            'total' => $q2->sum('end_price'),
            'pageData' => $this->paginate($q
            // ->where('created_at','>','2025-06-16T12:01:02')
            ->orderBy('created_at','desc'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('sales/create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'discount' => $request->header['discount'],
            'addition' => $request->header['addition'],
            'customer_name' => $request->header['customer_name'],
            'note' => $request->header['note'],
        ];
//        dd($data);
        $header = SaleHeader::factory()->create($data);
        if (Cache::has('sheft')) {
            $s=Cache::get('sheft');
            $header->update(['sheft_id' => $s->id]);
//            $s->headers()->attach([$header->id]);
        }
//        dd($request->items);
//        $table->foreignId('product_id');
//        $table->foreignId('header_id')->nullable();
//        $table->integer('quantity');
//        $table->double('end_price');
//        $table->double('cost_price')->nullable();
//        $table->double('unit_cost_price')->nullable();
//        $table->double('product_price')->nullable();
//        $table->double('discount')->nullable();
//        $table->double('profit')->default(0);
//        $table->integer('unit_id')->default(1);
//        $table->integer('unit_count')->nullable();

        foreach ($request->items as $item) {
            $unit = MeasureUnit::find($item['unit_id']);
            $product = Product::find($item['product_id']);
            $header->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],

                'end_price' =>(($unit->count  * $product->unit_price) - $unit->discount )*$item['quantity'],
                'product_price' => $product->unit_price,
                'unit_id' => $item['unit_id'],
                'unit_count' => $unit->count,
            ]);
        }
        $header->updateEndPrice();
        $this->success('done');
        return redirect()->route('sales.edit', $header->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return inertia('sales/show', [
            'row' => SaleHeader::query()->with('items')->find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return inertia('sales/edit', [
            'row' => SaleHeader::query()->with('items')->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'discount' => $request->header['discount'],
            'addition' => $request->header['addition'],
            'customer_name' => $request->header['customer_name'],
            'note' => $request->header['note'],
        ];

        $header = SaleHeader::query()->find($id);
        $header->update($data);

        foreach ($request->items as $item) {
            $unit = MeasureUnit::find($item['unit_id']);
            $product = Product::find($item['product_id']);
            if (array_key_exists('id',$item)) {
                $saleItem = SaleItem::query()->find($item['id']);
                $saleItem->update([
                    'quantity' => $item['quantity'],
                    'unit_id' => $item['unit_id'],
//                    'end_price' =>$unit->count * $item['quantity'] * $product->unit_price,
                    'end_price' =>(($unit->count  * $product->unit_price) - $unit->discount )*$item['quantity'],
                ]);
            }else{
                $header->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
//                    'end_price' => $unit->count * $item['quantity'] * $product->unit_price,
                    'end_price' =>(($unit->count  * $product->unit_price) - $unit->discount )*$item['quantity'],
                    'product_price' => $product->unit_price,
                    'unit_id' => $item['unit_id'],
                    'unit_count' => $unit->count,
                ]);
            }
        }
        $header->updateEndPrice();
        $this->success('updated successfully');
        return redirect()->route('sales.edit', $header->id);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $header = SaleHeader::query()->find($id);
        $header->items()->delete();
        $header->delete();
    }
    public function destroy_item(string $id)
    {
        $item = SaleItem::query()->find($id);
        $header_id = $item->header_id;
        $header = $item->header;
        $item->delete();
        $header->updateEndPrice();

        redirect()->route('sales.edit', $header_id);
    }
}
