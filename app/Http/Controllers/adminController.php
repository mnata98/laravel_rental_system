<?php

namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Employee;
use App\Models\Todo;
use Illuminate\Http\Request;

class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $total_cars = Car::count();
        $total_employees = Employee::count();

        // Todo
        $todos = Todo::orderBy('todo_id','DESC')->get();
        return view('admin.dashboard',[
            'total_cars'=>$total_cars,
            'total_employees'=>$total_employees,
            'todos'=>$todos
        ]);
    }

    // ... other methods if needed
}
