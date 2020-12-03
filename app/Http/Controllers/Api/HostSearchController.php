<?php

namespace App\Http\Controllers\Api;

use App\Models\HostSearch;
use Illuminate\Http\Request;

class HostSearchController extends Controller
{
    public function index()
    {
        $host = HostSearch::query()->orderBy('num', 'desc')->paginate(20);
        return $this->success($host);
    }
}
