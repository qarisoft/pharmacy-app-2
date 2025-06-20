<?php

namespace App;

use App\Models\Activities\CreatedBy;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @method static created(\Closure $param)
 * @method belongsTo(string $class, string $string)
 */
trait Blamable
{
    protected static function bootBlamable(): void
    {
        static::created(function ($model) {

            if (auth()->check()) {

                $model->createdBy()->create([
                    'user_id' => auth()->id() ?? 1,
                ]);
            }
        });
    }

    public function createdBy(): MorphOne
    {
        return $this->morphOne(CreatedBy::class, 'created_by');
    }
}
