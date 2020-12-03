<?php

namespace App\Models;

use App\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verse extends Model
{
    use HasFactory,
        HasDateTimeFormatter;

    public const STATUS_NORMAL = 1;
    public const STATUS_HIDEN = 0;

    public function poet()
    {
        return $this->belongsTo(Poet::class);
    }

    public function poetry()
    {
        return $this->belongsTo(Poetry::class);
    }
}
