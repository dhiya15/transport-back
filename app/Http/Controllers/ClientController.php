<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Parcelrequest;
use App\Models\Transportrequest;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function register(Request $request) {
        try {
            $data = Client::create($request->all());
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

    public function login(Request $request) {
        try {
            $data = Client::query()->firstWhere('email', $request->email)
                ->firstWhere("password", $request->password);
            if($data) {
                return response()->json([
                    "success" => true,
                    "data" => $data
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "data" => []
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => []
            ], 404);
        }
    }

    public function updateToken(Request $request) {
        $client = Client::find($request->id);
        if($client) {
            $client->token = $request->token;
            $client->update();
            return response()->json([
                'success' => true,
            ]);
        }else{
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function clientRequests(Request $request) {
        try {
            $prequests = Parcelrequest::query()->where("client_id", "=", $request->client_id)->get();
            $trequests = Transportrequest::query()->where("client_id", "=", $request->client_id)->get();
            if($prequests && $trequests) {
                return response()->json([
                    "success" => true,
                    "prequests" => $prequests,
                    "trequests" => $trequests
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "prequests" => [],
                    "trequests" => []
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "prequests" => [],
                "trequests" => []
            ], 404);
        }
    }
}
