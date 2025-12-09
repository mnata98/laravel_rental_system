@extends('admin.layout.master')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($rental) ? 'Edit Rental' : 'Add Rental' }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form action="{{ isset($rental) ? route('rentals.update', $rental->id) : route('rentals.store') }}" method="POST">
                            @csrf
                            @if(isset($rental))
                                @method('POST')
                            @endif

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Car</label>
                                    <select class="form-control" name="car_id" {{ isset($rental) ? 'disabled' : '' }}>
                                        <option value="">Select Car</option>
                                        @foreach($cars as $car)
                                            <option value="{{ $car->id }}" {{ (isset($rental) && $rental->car_id == $car->id) ? 'selected' : '' }}>
                                                {{ $car->brand }} {{ $car->model }} - {{ $car->plate_number }} ({{ $car->daily_rate }}/day)
                                            </option>
                                        @endforeach
                                    </select>
                                    @if(isset($rental))
                                        <input type="hidden" name="car_id" value="{{ $rental->car_id }}">
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" name="start_date" value="{{ $rental->start_date ?? '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" name="end_date" value="{{ $rental->end_date ?? '' }}" required>
                                </div>

                                <!-- Total Cost is calculated automatically, but maybe show strictly read-only or leave it to be calculated on save -->
                                @if(isset($rental))
                                    <div class="form-group">
                                        <label>Total Cost (Calculated on Save)</label>
                                        <input type="text" class="form-control" value="{{ $rental->total_cost }}" disabled>
                                    </div>
                                @endif
                                
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('rentals.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
