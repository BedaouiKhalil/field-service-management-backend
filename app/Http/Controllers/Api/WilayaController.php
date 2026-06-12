<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wilaya;
use Illuminate\Http\JsonResponse;

class WilayaController extends Controller
{
    public function communes(Wilaya $wilaya): JsonResponse
    {
        return response()->json(
            $wilaya->communes()->select('id', 'name')->orderBy('name')->get()
        );
    }
}
