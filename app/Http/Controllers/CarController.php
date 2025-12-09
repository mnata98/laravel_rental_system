<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {   
        $cars = Car::orderBy('id', 'desc')->get();
        // Assuming we will rename the view folder as well, or just point to 'cars.index'
        // For now let's assume we will rename 'admin.properties' to 'admin.cars'
        return view('admin.cars.index',['cars'=>$cars]);
    }

    public function search(Request $request)
    {   
        if($request->has('searchText')){
            $searchText = $request->searchText;
            $cars = Car::where('model','LIKE','%'.$searchText.'%')
                        ->orWhere('brand', 'LIKE', '%'.$searchText.'%')
                        ->get();
            return view('admin.cars.index',['cars'=>$cars]);
        }
    }

    public function create()
    {   
        return view('admin.cars.add-edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|integer',
            'plate_number' => 'required|unique:cars',
            'daily_rate' => 'required|numeric',
        ]);

        $car = new Car;
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->year = $request->year;
        $car->plate_number = $request->plate_number;
        $car->type = $request->type; // Sedan, SUV
        $car->daily_rate = $request->daily_rate;
        $car->description = $request->description;
        
        // Handle Image Upload if needed later
        if($request->hasFile('image')){
             // implementation for image upload
             $path = $request->file('image')->store('cars', 'public');
             $car->image = $path;
        }

        $car->save();
        return redirect()->route('cars.index')->with('success', 'Car added successfully');
    }

    public function edit($id)
    {
        $car = Car::find($id);
        return view('admin.cars.add-edit',['car'=>$car]);
    }

    public function update(Request $request, $id)
    {
        $car = Car::find($id);
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->year = $request->year;
        $car->plate_number = $request->plate_number;
        $car->type = $request->type;
        $car->daily_rate = $request->daily_rate;
        $car->description = $request->description;
        
        // Handle Image Upload
        if($request->hasFile('image')){
            $path = $request->file('image')->store('cars', 'public');
            $car->image = $path;
        }
        
        $car->save();
        return redirect()->route('cars.index')->with('success', 'Car updated successfully');
    }

    public function destroy($id)
    {
        $car = Car::find($id);
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Car deleted successfully');
    }
}
