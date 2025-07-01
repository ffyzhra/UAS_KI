<?php

namespace App\Providers;

use App\Models\Pendaftaran;
use App\Policies\ActivityPolicy;
use Filament\Actions\MountableAction;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Activity::class, ActivityPolicy::class);

        // 🟡 Auto-generate Pendaftaran saat mahasiswa login
        if (Auth::check() && Auth::user()->hasRole('mahasiswa')) {
            $user = Auth::user();
            $mahasiswa = $user->mahasiswa;

            if ($mahasiswa && !Pendaftaran::where('mahasiswa_id', $mahasiswa->id)->exists()) {
                // Ganti 1 dengan beasiswa_id yang sesuai dengan sistem kamu
                Pendaftaran::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'beasiswa_id' => 1,
                ]);
            }
        }

        // Konfigurasi tambahan Filament
        Page::formActionsAlignment(Alignment::Right);
        Notifications::alignment(Alignment::End);
        Notifications::verticalAlignment(VerticalAlignment::End);
        Page::$reportValidationErrorUsing = function (ValidationException $exception) {
            Notification::make()
                ->title($exception->getMessage())
                ->danger()
                ->send();
        };
        MountableAction::configureUsing(function (MountableAction $action) {
            $action->modalFooterActionsAlignment(Alignment::Right);
        });
    }
}