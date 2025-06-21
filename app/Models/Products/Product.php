<?php

namespace App\Models\Products;

use App\Blamable;
use App\Models\Activities\Close;
use App\Models\Activities\CreatedBy;
use App\Models\Sales\SaleItem;
use App\Models\Store\ProductInput;
use App\Models\User;
use App\Models\Products\Company;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\Products\ProductFactory> */
    use HasFactory;

    protected $with = ['units'];
    protected $guarded = [];

    #[Scope]
    public function search(Builder $query, $search): Builder
    {
        return $query->where('barcode', 'LIKE', "%{$search}%")
            ->orWhere('name_ar', 'like', "%{$search}%")
            ->orWhere('name_en', 'like', "%{$search}%")
            ->orWhere('scientific_name', 'like', "%{$search}%");

    }

    static function staticSearch(string $search): array
    {
        return Product::query()
            ->where('barcode', 'like', "%{$search}%")
            ->orWhere('name_ar', 'like', "%{$search}%")
            ->orWhere('name_en', 'like', "%{$search}%")
            ->orWhere('scientific_name', 'like', "%{$search}%")
            ->limit(50)
            ->pluck('name_ar', 'id')
            ->toArray();
    }


    public function unit_cost_price()
    {
        return $this->hasMany(ProductInput::class, 'product_id')->latest()->limit(1);
    }


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function price(): HasOne
    {
        return $this->hasOne(Price::class);
    }

    public function unitPrice()
    {
        return $this->unit_price ?? 0;
    }

    public function storeItems(): HasMany
    {
        return $this->hasMany(ProductInput::class);
    }

    public function lastStoreItem(): HasOne
    {
        return $this->hasOne(ProductInput::class)->orderBy('unit_cost_price')->limit(1);
    }

    public function inStore(): int
    {
        return $this->inputItemsCount() - $this->soldItemsCount();
    }

    public function inputItems(): HasMany
    {
        return $this->hasMany(ProductInput::class);
    }

    public function inputItemsCount()
    {
        return $this->hasMany(ProductInput::class)->sum('quantity');
    }

    public function soldItemsCount()
    {
        return $this->hasMany(SaleItem::class)->sum('quantity');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }


    public function createdBy(): MorphOne
    {
        return $this->morphOne(CreatedBy::class, 'created_by');
    }

    public function units(): HasMany
    {
        return $this->hasMany(MeasureUnit::class);
    }

    static function cache(): void
    {
        Cache::add('products', Product::query()->whereHas('units')->with('units')->get());

    }

    static function recache(): void
    {
        Cache::forget('products');
        Product::cache();
    }

    public function closed(): MorphOne
    {
        return $this->morphOne(Close::class, 'closeable');
    }


    protected static function booted(): void
    {
        static::created(function (Product $product) {
            if (auth()->check()) {

                if (str_contains($product->name_ar, 'فيال')) {
                    $product->units()->create([
                        'name' => MeasureUnitName::find(4)->name,
                        'count' => 1,
//                    'is_cost'=>true
                    ]);
                } elseif (str_contains($product->name_ar, 'شراب')) {
                    $product->units()->create([
                        'name' => MeasureUnitName::find(6)->name,
                        'count' => 1,
//                    'is_cost'=>true
                    ]);
                } elseif (str_contains($product->name_ar, 'امبول')) {
                    $product->units()->create([
                        'name' => MeasureUnitName::find(2)->name,
                        'count' => 1,
//                    'is_cost'=>true
                    ]);
                }elseif (str_contains($product->name_ar, 'اكياس')) {
                    $product->units()->create([
                        'name' => MeasureUnitName::find(11)->name,
                        'count' => 1,
//                    'is_cost'=>true
                    ]);
                } elseif (str_contains($product->name_ar, 'تحاميل')) {
                    $product->units()->create([
                        'name' => 'تحميلة',
                        'count' => 1,
//                    'is_cost'=>true
                    ]);
                } elseif (str_contains($product->name_ar, 'جل')) {
                    $product->units()->create([
                        'name' => 'جل',
                        'count' => 1,
//                    'is_cost'=>true
                    ]);
                }else {
                    $product->units()->create([
                        'name' => 'default',
                        'count' => 1,
//                    'is_cost'=>true
                    ]);
                }
                Product::recache();
            }
        });

        static::updated(function (Product $product) {
            Product::recache();
        });


        static ::creating(function (Product $product) {
            if (!$product->barcode2){
                $product->barcode2=fake()->unique()->randomNumber(8);
            }
        });
    }


}
