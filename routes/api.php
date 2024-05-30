<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/client-register', [\App\Http\Controllers\ClientController::class, 'register']);
Route::post('/transporter-register', [\App\Http\Controllers\TransporterController::class, 'register']);
Route::post('/client-login', [\App\Http\Controllers\ClientController::class, 'login']);
Route::post('/transporter-login', [\App\Http\Controllers\TransporterController::class, 'login']);
Route::get('/parcels', [\App\Http\Controllers\ParcelController::class, 'getAll']);
Route::get('/destination', [\App\Http\Controllers\DestinationController::class, 'search']);
Route::post('/parcel-request', [\App\Http\Controllers\ParcelrequestController::class, 'store']);
Route::post('/transport-request', [\App\Http\Controllers\TransportrequestController::class, 'store']);
Route::get('/get-parcel-request', [\App\Http\Controllers\ParcelrequestController::class, 'getParcelRequests']);
Route::get('/get-transport-request', [\App\Http\Controllers\TransportrequestController::class, 'getTransportRequests']);
Route::post('/confirm-parcel-request', [\App\Http\Controllers\ParcelrequestController::class, 'confirmParcelRequests']);
Route::post('/confirm-transport-request', [\App\Http\Controllers\TransportrequestController::class, 'confirmTransportRequests']);
Route::get('/client-requests', [\App\Http\Controllers\ClientController::class, 'clientRequests']);
Route::get('/transporter-requests', [\App\Http\Controllers\TransporterController::class, 'transporterRequests']);
