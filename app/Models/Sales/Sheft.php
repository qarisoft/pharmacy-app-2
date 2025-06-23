<?php

namespace App\Models\Sales;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Sheft extends Model
{
    /** @use HasFactory<\Database\Factories\Sales\SheftFactory> */
    use HasFactory;
    protected $guarded=[];
    static function forget(): void
    {
        Cache::forget('sheft');
    }
    static function cacheLast(): void
    {
        Cache::put('sheft',Sheft::query()->latest()->limit(1)->get()[0]);
    }
    static function recache($id): void
    {
        Cache::put('sheft',Sheft::query()->find($id));
    }

    protected $with=['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function headers(): HasMany
    {
        return $this->hasMany(SaleHeader::class);
    }
}
