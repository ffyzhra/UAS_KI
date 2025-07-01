<?php

namespace App\Filament\Mahasiswa\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;

class UserStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Users', User::count())
                ->icon('heroicon-o-user-group')
                ->description('Jumlah pengguna saat ini'),
        ];
    }
}