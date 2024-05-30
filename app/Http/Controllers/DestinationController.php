<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function search(Request $request) {
        try {
            $data = Destination::query()->where('from', $request->from)
                        ->where('to', $request->to)
                        ->get();
            return response()->json([
                "success" => true,
                "data" => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage()
            ], 404);
        }
    }
}
