<?php

namespace App\Filament\Admin\Resources\SeleksiResource\Pages;

use App\Filament\Admin\Resources\SeleksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeleksis extends ListRecords
{
    protected static string $resource = SeleksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
