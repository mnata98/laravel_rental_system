<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Vehicle;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Bookings', Booking::count())
                ->description('All time bookings')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('primary'),
            Card::make('Total Revenue', 'RM ' . number_format(Payment::where('status', 'paid')->sum('amount'), 2))
                ->description('Total paid invoices')
                ->descriptionIcon('heroicon-s-currency-dollar')
                ->color('success'),
            Card::make('Active Vehicles', Vehicle::where('status', 'available')->count())
                ->description('Vehicles ready for rent')
                ->descriptionIcon('heroicon-s-truck')
                ->color('warning'),
        ];
    }
}
