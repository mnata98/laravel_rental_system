<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book {{ $car->brand }} {{ $car->model }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5', 
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Confirm Reservation
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                for {{ $car->brand }} {{ $car->model }}
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Pick-up Date</label>
                        <div class="mt-1">
                            <input type="text" name="start_date" id="start_date" required placeholder="Select Pick-up Date"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm bg-white">
                        </div>
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Return Date</label>
                        <div class="mt-1">
                            <input type="text" name="end_date" id="end_date" required placeholder="Select Return Date"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm bg-white">
                        </div>
                    </div>

                    <!-- Simple Cost Calc Display -->
                    <div class="bg-indigo-50 p-4 rounded-md">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Daily Rate:</span>
                            <span>${{ number_format($car->daily_rate, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-gray-900 pt-2 border-t border-indigo-100">
                            <span>Total Estimated:</span>
                            <span id="total_display">$0.00</span>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Proceed to Payment
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('car.show', $car->id) }}" class="text-sm text-gray-500 hover:text-gray-900">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const blockedDates = @json($blockedDates);
            const dailyRate = {{ $car->daily_rate }};
            const totalDisplay = document.getElementById('total_display');
            
            const commonConfig = {
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: blockedDates,
                onChange: calculateTotal
            };

            const fpStart = flatpickr("#start_date", commonConfig);
            const fpEnd = flatpickr("#end_date", commonConfig);

            function calculateTotal() {
                const startDate = fpStart.selectedDates[0];
                const endDate = fpEnd.selectedDates[0];

                if(startDate && endDate) {
                    if(endDate > startDate) {
                        const diffTime = Math.abs(endDate - startDate);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                        
                        // Check if any blocked date exists between start and end ??
                        // Advanced validation can be added here, but basics first.
                        
                        const total = diffDays * dailyRate;
                        totalDisplay.innerText = '$' + total.toFixed(2);
                    } else {
                        // If same day or invalid range
                         if (endDate.getTime() === startDate.getTime()){
                            totalDisplay.innerText = '$' + dailyRate.toFixed(2) + ' (1 Day)';
                        } else {
                             totalDisplay.innerText = '$' + dailyRate.toFixed(2) + ' (Min 1 day)';
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
