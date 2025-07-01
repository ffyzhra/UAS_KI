<?php

namespace App\Filament\Mahasiswa\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\LogActivity;

class DashboardMahasiswa extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Dashboard';
    protected static string $view = 'filament.mahasiswa.pages.dashboard-mahasiswa';

    public function getHeading(): string
    {
        return 'Dashboard';
    }

    protected function getViewData(): array
    {
        return [
            'userCount' => User::count(),
            'logs' => LogActivity::where('user_id', auth()->id())->latest()->take(5)->get(),
        ];
    }
}