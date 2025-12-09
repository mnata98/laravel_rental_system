@extends('admin.layout.master')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($car) ? 'Edit Car' : 'Add Car' }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form action="{{ isset($car) ? route('cars.update', $car->id) : route('cars.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($car))
                                @method('POST') 
                                <!-- Note: Typically update uses PUT/PATCH but the controller might expect POST based on original code style or if we define Route::post for update. 
                                     The original routes used POST for update. Let's stick to POST as per web.php routes I defined earlier which used Route::post('/update/{id}'...) -->
                            @endif
                            
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Brand</label>
                                    <input type="text" class="form-control" name="brand" value="{{ $car->brand ?? '' }}" placeholder="Enter Brand" required>
                                </div>
                                <div class="form-group">
                                    <label>Model</label>
                                    <input type="text" class="form-control" name="model" value="{{ $car->model ?? '' }}" placeholder="Enter Model" required>
                                </div>
                                <div class="form-group">
                                    <label>Year</label>
                                    <input type="number" class="form-control" name="year" value="{{ $car->year ?? '' }}" placeholder="Enter Year" required>
                                </div>
                                <div class="form-group">
                                    <label>Plate Number</label>
                                    <input type="text" class="form-control" name="plate_number" value="{{ $car->plate_number ?? '' }}" placeholder="Enter Plate Number" required>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="type">
                                        <option value="Sedan" {{ (isset($car) && $car->type == 'Sedan') ? 'selected' : '' }}>Sedan</option>
                                        <option value="SUV" {{ (isset($car) && $car->type == 'SUV') ? 'selected' : '' }}>SUV</option>
                                        <option value="Truck" {{ (isset($car) && $car->type == 'Truck') ? 'selected' : '' }}>Truck</option>
                                        <option value="Van" {{ (isset($car) && $car->type == 'Van') ? 'selected' : '' }}>Van</option>
                                        <option value="Luxury" {{ (isset($car) && $car->type == 'Luxury') ? 'selected' : '' }}>Luxury</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Daily Rate</label>
                                    <input type="number" step="0.01" class="form-control" name="daily_rate" value="{{ $car->daily_rate ?? '' }}" placeholder="Enter Daily Rate" required>
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="form-control-file" name="image">
                                    @if(isset($car) && $car->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $car->image) }}" alt="Car Image" style="width: 100px; height: auto;">
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Enter Description">{{ $car->description ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('cars.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
