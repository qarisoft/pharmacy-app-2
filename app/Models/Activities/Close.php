<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Close extends Model
{
    /** @use HasFactory<\Database\Factories\Activities\CloseFactory> */
    use HasFactory;



    protected $guarded=[];

    public function closeable(): MorphTo
    {
        return $this->morphTo();
    }
}
