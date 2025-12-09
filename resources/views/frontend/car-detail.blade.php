<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $car->brand }} {{ $car->model }} - Rent A Car</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5', // Indigo 600
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full z-10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('landing') }}" class="text-3xl font-bold text-gray-900 tracking-tight">
                        Rent<span class="text-primary">Car</span>
                    </a>
                </div>
                <!-- Simple Nav Links -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('landing') }}" class="text-gray-600 hover:text-primary font-medium">Back to Fleet</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-24 pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="md:flex">
                <div class="md:flex-shrink-0 md:w-1/2 relative h-96 md:h-auto">
                    @if($car->image)
                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->model }}">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>
                <div class="p-8 md:w-1/2 flex flex-col justify-center">
                    <div class="uppercase tracking-wide text-sm text-primary font-semibold">{{ $car->type }}</div>
                    <h1 class="mt-2 text-4xl font-extrabold text-gray-900">{{ $car->brand }} {{ $car->model }}</h1>
                    <div class="mt-2 flex items-center">
                        <span class="text-gray-500">{{ $car->year }}</span>
                        <span class="mx-2 text-gray-300">&bull;</span>
                        <span class="text-gray-500">{{ $car->plate_number }}</span>
                    </div>
                    
                    <p class="mt-4 text-gray-600 text-lg leading-relaxed">
                        {{ $car->description ?? 'No description available for this vehicle.' }}
                    </p>

                    <div class="mt-8 border-t border-gray-100 pt-8">
                        
                        <!-- Availability Calendar -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Availability Calendar</h3>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <input type="text" id="availability_calendar" class="hidden" placeholder="Check Availability">
                                <div id="inline_calendar"></div>
                                <div class="mt-2 text-sm text-gray-500">
                                    <span class="inline-block w-3 h-3 bg-red-400 rounded-full mr-1"></span> Booked
                                    <span class="inline-block w-3 h-3 bg-white border border-gray-300 rounded-full ml-3 mr-1"></span> Available
                                </div>
                            </div>
                        </div>

                        <div class="flex items-baseline mb-6">
                            <span class="text-5xl font-extrabold text-gray-900">${{ number_format($car->daily_rate, 0) }}</span>
                            <span class="text-xl text-gray-500 ml-1">/ day</span>
                        </div>

                        @auth
                            <a href="{{ route('booking.create', $car->id) }}" class="w-full bg-primary text-white text-center py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Book This Car Now
                            </a>
                        @else
                            <a href="{{ route('login1') }}" class="w-full block bg-gray-900 text-white text-center py-4 rounded-xl font-bold text-lg hover:bg-gray-800 transition">
                                Login to Book
                            </a>
                            <p class="mt-3 text-center text-sm text-gray-500">You need an account to make a reservation.</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flatpickr CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .flatpickr-calendar {
            box-shadow: none !important;
            width: 100% !important;
        }
        .flatpickr-days {
            width: 100% !important;
        }
        .dayContainer {
            width: 100% !important;
            min-width: unset !important;
            max-width: unset !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const blockedDates = @json($blockedDates);
            
            flatpickr("#inline_calendar", {
                inline: true,
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: blockedDates,
                locale: {
                    firstDayOfWeek: 1
                }
            });
        });
    </script>

</body>
</html>
