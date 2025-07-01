<?php

namespace App\Filament\Admin\Resources\SeleksiResource\Pages;

use App\Filament\Admin\Resources\SeleksiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeleksi extends EditRecord
{
    protected static string $resource = SeleksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
