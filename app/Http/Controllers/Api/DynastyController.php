<?php

namespace App\Http\Controllers\Api;

use App\Models\Dynasty;
use Illuminate\Http\Request;
use App\Http\Resources\Dynasty as DynsatyResource;

class DynastyController extends Controller
{

    public function index()
    {
        $dynasties = Dynasty::all();
        return $this->success(DynsatyResource::collection($dynasties));
    }

}
