<?php

use App\Http\Middleware\Authenticate;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\adminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\employeesController; // Assuming this stays or we might refactor later if needed
use App\Http\Controllers\locationsController; // Might not be needed if locations are just strings
use App\Http\Controllers\emailsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::view('/', 'login1');
use App\Http\Controllers\FrontendController;

// Route::view('/', 'login1');
Route::get('/', [FrontendController::class, 'index'])->name('landing');
Route::view('/login', 'auth.login1')->name('login1');
Route::view('/register1', 'auth.register1')->name('register1');

Auth::routes();

// Admin Routes
Route::get('/admin', [adminController::class, 'index'])->name('Dashboard')->middleware('auth');

// Route::post('/locations/store', [locationsController::class, 'store']); // check if used

Route::middleware([Authenticate::class])->group(function () {

    // Cars
    Route::prefix('cars')->group(function () {
        Route::get('/', [CarController::class, 'index'])->name('cars.index');
        Route::get('/create', [CarController::class, 'create'])->name('cars.create');
        Route::post('/store', [CarController::class, 'store'])->name('cars.store');
        Route::get('/delete/{id}', [CarController::class, 'destroy'])->name('cars.destroy');
        Route::get('/edit/{id}', [CarController::class, 'edit'])->name('cars.edit');
        Route::post('/update/{id}', [CarController::class, 'update'])->name('cars.update');
    });
    
    // Rentals
    Route::prefix('rentals')->group(function () {
        Route::get('/', [RentalController::class, 'index'])->name('rentals.index');
        Route::get('/create', [RentalController::class, 'create'])->name('rentals.create');
        Route::post('/store', [RentalController::class, 'store'])->name('rentals.store');
        Route::get('/delete/{id}', [RentalController::class, 'destroy'])->name('rentals.destroy');
        Route::get('/edit/{id}', [RentalController::class, 'edit'])->name('rentals.edit');
        Route::post('/update/{id}', [RentalController::class, 'update'])->name('rentals.update');
    });

    // Employees (Keep for now or refactor later)
    Route::prefix('employees')->group(function () {
        Route::get('/', [employeesController::class, 'index'])->name('employees');
        Route::get('/create', [employeesController::class, 'create'])->name('Create Employee');
        Route::post('/store', [employeesController::class, 'store'])->name('create.employee');
        Route::get('/delete/{pid}', [employeesController::class, 'destroy']);
        Route::get('/edit/{pid}', [employeesController::class, 'edit']);
        Route::post('/update/{pid}', [employeesController::class, 'update'])->name('update.employee');
    });

    // Email
    Route::prefix('emails')->group(function () {
        Route::get('/compose', [emailsController::class, 'compose'])->name('compose');
        Route::get('/inbox', [emailsController::class, 'inbox'])->name('inbox');
        Route::get('/send-mail', [emailsController::class, 'sendMail']);
    });
 
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public Car Detail
Route::get('/car/{id}', [App\Http\Controllers\BookingController::class, 'showCar'])->name('car.show');

// Customer Booking Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/create/{carId}', [App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/payment/{rentalId}', [App\Http\Controllers\BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/pay/{rentalId}', [App\Http\Controllers\BookingController::class, 'processPayment'])->name('booking.pay');
    Route::get('/my-bookings', [App\Http\Controllers\BookingController::class, 'myBookings'])->name('booking.history');
});