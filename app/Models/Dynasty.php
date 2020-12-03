<?php

namespace App\Models;

use App\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dynasty extends Model
{
    use HasFactory,
        SoftDeletes,
        HasDateTimeFormatter;

    protected $fillable = [
        'name',
        'desc',
    ];
}
