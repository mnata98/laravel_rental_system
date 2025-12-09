<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Vehicle;
use App\Models\Booking;

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

// List available vehicles
Route::get('/vehicles/available', function () {
    return Vehicle::where('status', 'available')->get();
});

// Check availability
Route::get('/availability', function (Request $request) {
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'vehicle_id' => 'required|exists:vehicles,id',
    ]);

    $exists = Booking::where('vehicle_id', $request->vehicle_id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
        })
        ->exists();

    return response()->json(['available' => !$exists]);
});

// Create Booking
Route::post('/bookings', function (Request $request) {
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'vehicle_id' => 'required|exists:vehicles,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $vehicle = Vehicle::find($request->vehicle_id);
    $days = \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1;
    $total = $days * $vehicle->daily_rate;

    $booking = Booking::create([
        'customer_id' => $request->customer_id,
        'vehicle_id' => $request->vehicle_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'total_price' => $total,
        'status' => 'pending',
    ]);

    return response()->json($booking, 201);
});
