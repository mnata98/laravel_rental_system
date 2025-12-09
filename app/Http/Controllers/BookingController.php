<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function showCar($id)
    {
        $car = Car::findOrFail($id);
        
        // Get blocked dates for availability calendar
        $bookings = Rental::where('car_id', $id)
            ->where('end_date', '>=', now())
            ->whereIn('status', ['active', 'confirmed', 'pending_payment', 'paid'])
            ->get(['start_date', 'end_date']);

        $blockedDates = $bookings->map(function($booking) {
            return [
                'from' => substr($booking->start_date, 0, 10),
                'to' => substr($booking->end_date, 0, 10),
            ];
        });

        return view('frontend.car-detail', compact('car', 'blockedDates'));
    }

    public function create($carId)
    {
        $car = Car::findOrFail($carId);
        
        // Get blocked dates
        $bookings = Rental::where('car_id', $carId)
            ->where('end_date', '>=', now())
            ->whereIn('status', ['active', 'confirmed', 'pending_payment', 'paid'])
            ->get(['start_date', 'end_date']);

        $blockedDates = $bookings->map(function($booking) {
            return [
                'from' => substr($booking->start_date, 0, 10),
                'to' => substr($booking->end_date, 0, 10),
            ];
        });

        return view('frontend.booking-create', compact('car', 'blockedDates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Car::findOrFail($request->car_id);
        
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);

        // Check for overlap
        $exists = Rental::where('car_id', $car->id)
            ->whereIn('status', ['active', 'confirmed', 'pending_payment', 'paid'])
            ->where(function($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                      ->orWhereBetween('end_date', [$start, $end])
                      ->orWhere(function($query) use ($start, $end) {
                          $query->where('start_date', '<', $start)
                                ->where('end_date', '>', $end);
                      });
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['start_date' => 'Selected dates are already booked. Please choose different dates.']);
        }

        $days = $start->diffInDays($end) ?: 1; // Minimum 1 day
        $total_cost = $days * $car->daily_rate;

        $rental = new Rental();
        $rental->car_id = $car->id;
        $rental->user_id = Auth::id();
        $rental->start_date = $request->start_date;
        $rental->end_date = $request->end_date;
        $rental->total_cost = $total_cost;
        $rental->status = 'pending_payment'; // New status
        $rental->save();

        return redirect()->route('booking.payment', $rental->id);
    }

    public function payment($rentalId)
    {
        $rental = Rental::with('car')->where('user_id', Auth::id())->findOrFail($rentalId);
        return view('frontend.payment', compact('rental'));
    }

    public function processPayment(Request $request, $rentalId)
    {
        $rental = Rental::where('user_id', Auth::id())->findOrFail($rentalId);
        
        // Simulate payment processing
        // In a real app, integrate Stripe/PayPal here

        $payment = new Payment();
        // Assuming your Payment model uses rental_id. The existing model uses booking_id.
        // We will adapt the Payment model or use booking_id field for rental_id if standardizing.
        // For now let's assume we map booking_id to rental->id as they are conceptually same here.
        $payment->booking_id = $rental->id; 
        $payment->amount = $rental->total_cost;
        $payment->payment_date = now();
        $payment->method = $request->payment_method;
        $payment->status = 'paid';
        $payment->save();

        $rental->status = 'active'; // Or 'confirmed'
        $rental->save();
        
        // Mark car as rented? Or handle availability by date ranges?
        // Simple logic:
        $rental->car->status = 'rented';
        $rental->car->save();

        return redirect()->route('booking.history')->with('success', 'Booking confirmed and paid!');
    }

    public function myBookings()
    {
        $rentals = Rental::with('car')
                         ->where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get();
                         
        return view('frontend.my-bookings', compact('rentals'));
    }
}
