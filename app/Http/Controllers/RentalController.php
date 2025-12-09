<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use App\Models\User; // Assuming we link to users
// use App\Models\Employee; // If needed

class RentalController extends Controller
{
    public function index()
    {   
        $rentals = Rental::orderBy('id', 'desc')->with('car')->get();
        return view('admin.rentals.index',['rentals'=>$rentals]);
    }

    public function create()
    {   
        $cars = Car::where('status', 'available')->get();
        // Assuming we might want to select a user manually in admin panel
        // $users = User::all(); 
        return view('admin.rentals.add-edit', ['cars'=>$cars]);
    }

    public function store(Request $request)
    {   
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Car::find($request->car_id);
        
        // Calculate total cost
        $start = \Carbon\Carbon::parse($request->start_date);
        $end = \Carbon\Carbon::parse($request->end_date);
        $days = $start->diffInDays($end);
        $total_cost = $days * $car->daily_rate;

        $rental = new Rental;
        $rental->car_id = $request->car_id;
        $rental->user_id = auth()->id(); // Or from request if admin selects user
        $rental->start_date = $request->start_date;
        $rental->end_date = $request->end_date;
        $rental->total_cost = $total_cost;
        $rental->status = 'active';
        $rental->save();

        // Update car status
        $car->status = 'rented';
        $car->save();

        return redirect()->route('rentals.index')->with('success', 'Rental created successfully');
    }

    public function edit($id)
    {
        $rental = Rental::find($id);
        $cars = Car::all();
        return view('admin.rentals.add-edit',['rental'=>$rental, 'cars'=>$cars]);
    }

    public function update(Request $request, $id)
    {
        $rental = Rental::find($id);
        $rental->start_date = $request->start_date;
        $rental->end_date = $request->end_date;
        // Recalculate cost if dates changed... logic here
        $rental->save();
        return redirect()->route('rentals.index');
    }

    public function destroy($id)
    {
        $rental = Rental::find($id);
        // Make car available again if deleting active rental
        if($rental->status == 'active') {
            $car = $rental->car;
            $car->status = 'available';
            $car->save();
        }
        $rental->delete();
        return redirect()->route('rentals.index');
    }
}
