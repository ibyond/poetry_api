<?php

namespace App\Models;

use App\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;


class Poet extends Model
{
    use HasFactory,
        SoftDeletes,
        HasDateTimeFormatter;

    protected $fillable = [
        'name',
        'image',
        'dynasty_name',
        'dynasty_id',
        'desc',
        'content',
        'star',
    ];

    public function getImageAttribute($value)
    {
        if (!$value) {
            return config('app.url') . '/img/default-avatar.png';
        }
        if (!str_starts_with($value, 'http')) {
            return Storage::disk('admin')->url($value);
        }
        return $value;
    }

    public function dynasty()
    {
        return $this->belongsTo(Dynasty::class);
    }
}
