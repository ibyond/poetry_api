<?php

namespace App\Models;

use App\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostSearch extends Model
{
    use HasFactory,HasDateTimeFormatter;

    protected $fillable = ['content', 'num'];
}
