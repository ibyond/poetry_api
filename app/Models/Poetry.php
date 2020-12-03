<?php

namespace App\Models;

use App\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poetry extends Model
{
    use HasFactory,
        SoftDeletes,
        HasDateTimeFormatter;

    public const STATUS_NORMAL = 1;
    public const STATUS_HIDEN = 0;

    protected $fillable = [
        'name',
        'dynasty_name',
        'dynasty_id',
        'content',
        'poet_id',
        'star',
        'fanyi',
        'shangxi',
        'about',
        'status',
    ];
    public function dynasty()
    {
        return $this->belongsTo(Dynasty::class);
    }

    public function poet()
    {
        return $this->belongsTo(Poet::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'poetry_tags');
    }
}
