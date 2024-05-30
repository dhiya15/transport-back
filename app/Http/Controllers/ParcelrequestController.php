<?php

namespace App\Http\Controllers;

use App\Models\Parcelrequest;
use App\Models\Transporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ParcelrequestController extends Controller
{
    public function store(Request $request) {
        try {
            $data = Parcelrequest::create($request->all());


            $transporters = Transporter::query()
                ->where("type", "truck")
                ->get();
            $tokens = [];
            foreach($transporters as $transporter) {
                $tokens[] = $transporter->token;
            }
            $data2 = [
                "registration_ids" => $tokens,
                "notification" => [
                    "title" => "طلب جديد",
                    "body" => "احد مستخدمي التطبيق يحتاج الى شاحنة لنقل البضائع",
                    "priority" => "high",
                ],
            ];
            $response = Http::withHeaders([
                'Authorization' => 'key=AAAACsCuM0Y:APA91bEvg3B45cMN5HovlVwdbcxFJwDtn0AJVOuhjjmaiLf4fOK_QIRxKbG7Ay2gE0le8qQK1iqEJjC34BSuobEIi5c6SEX6yELg3TTC5dBjoCAcMxtKx8-wJakxwn_vzTwoeEVUB5fQ',
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', $data2);
            $is_sent = false;
            if ($response->successful()) {
                $is_sent = true;
            }


            return response()->json([
                "success" => true,
                "data" => $data,
                "is_sent" => $is_sent,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage()
            ], 404);
        }
    }

    public function getParcelRequests(Request $request) {
        try {
            $data = Parcelrequest::query()
                ->where('transporter_id', "=", null)
                ->get();
            return response()->json([
                "success" => true,
                "data" => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage()
            ], 404);
        }
    }

    public function confirmParcelRequests(Request $request) {
        try {
            $data = Parcelrequest::with('client')->find($request->request_id);
            if($data && $data->transporter_id == null) {
                $data->transporter_id = $request->transporter_id;
                $data->update();

                $data2 = [
                    "to" => $data->client->token,
                    "notification" => [
                        "title" => "طلب جديد",
                        "body" => "تمت الموافقة على طلبك الخاص بسيارة اجرة",
                        "priority" => "high",
                    ],
                ];
                $response = Http::withHeaders([
                    'Authorization' => 'key=AAAACsCuM0Y:APA91bEvg3B45cMN5HovlVwdbcxFJwDtn0AJVOuhjjmaiLf4fOK_QIRxKbG7Ay2gE0le8qQK1iqEJjC34BSuobEIi5c6SEX6yELg3TTC5dBjoCAcMxtKx8-wJakxwn_vzTwoeEVUB5fQ',
                    'Content-Type' => 'application/json',
                ])->post('https://fcm.googleapis.com/fcm/send', $data2);
                $is_sent = false;
                if ($response->successful()) {
                    $is_sent = true;
                }

                return response()->json([
                    "success" => true,
                    "data" => $data,
                    "is_sent" => $is_sent,
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "تم حجز هذا الطلب"
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage()
            ], 404);
        }
    }
}
