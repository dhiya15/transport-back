<?php

namespace App\Http\Controllers;

use App\Models\Parcelrequest;
use App\Models\Transporter;
use App\Models\Transportrequest;
use Illuminate\Http\Request;

class TransporterController extends Controller
{
    public function register(Request $request) {
        try {

            $data = $request->all();
            $disk = "public";
            $destination_path = "requests/documents";
            if (request()->hasFile('documents')) {
                $fileName = md5($request->documents->getClientOriginalName().random_int(1, 9999).time()).'.'. $request->documents->getClientOriginalExtension();
                $request->file('documents')->storeAs($destination_path, $fileName, $disk);
                $data['documents'] = $destination_path . '/' . $fileName;
            }
            $data = Transporter::create($data);
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
            $data = Transporter::query()->firstWhere('email', $request->email)
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
        $client = Transporter::find($request->id);
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

    public function transporterRequests(Request $request) {
        try {
            $prequests = Parcelrequest::query()->where("transporter_id", "=", $request->transporter_id)->get();
            $trequests = Transportrequest::query()->where("transporter_id", "=", $request->transporter_id)->get();
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
