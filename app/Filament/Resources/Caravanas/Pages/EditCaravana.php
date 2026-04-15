<?php

namespace App\Filament\Resources\Caravanas\Pages;

use App\Filament\Resources\Caravanas\CaravanaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCaravana extends EditRecord
{
    protected static string $resource = CaravanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
