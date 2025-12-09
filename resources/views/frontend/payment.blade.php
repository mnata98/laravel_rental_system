<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment - {{ $rental->car->brand }} {{ $rental->car->model }}</title>
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
                        primary: '#4F46E5', 
                        success: '#10B981',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="mx-auto h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Secure Payment
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Booking Summary</h3>
                    <div class="mt-3 flex justify-between text-sm">
                        <span class="text-gray-500">Vehicle</span>
                        <span class="font-medium">{{ $rental->car->brand }} {{ $rental->car->model }}</span>
                    </div>
                    <div class="mt-2 flex justify-between text-sm">
                        <span class="text-gray-500">Dates</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($rental->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($rental->end_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="mt-2 flex justify-between text-base font-bold text-gray-900 pt-2 border-t border-dashed border-gray-200">
                        <span>Total Amount</span>
                        <span class="text-primary">${{ number_format($rental->total_cost, 2) }}</span>
                    </div>
                </div>

                <form action="{{ route('booking.pay', $rental->id) }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="credit_card" checked class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                <span class="ml-3 block text-sm font-medium text-gray-700">Credit Card</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="cash" class="h-4 w-4 text-primary focus:ring-primary border-gray-300">
                                <span class="ml-3 block text-sm font-medium text-gray-700">Cash on Pickup</span>
                            </label>
                            <!-- eWallet option can be added -->
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Pay ${{ number_format($rental->total_cost, 2) }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
