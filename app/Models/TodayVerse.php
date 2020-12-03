<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodayVerse extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['verse_id', 'time'];

    public function verse()
    {
        return $this->belongsTo(Verse::class);
    }
}
