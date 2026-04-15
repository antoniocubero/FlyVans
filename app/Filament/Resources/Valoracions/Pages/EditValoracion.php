<?php

namespace App\Filament\Resources\Valoracions\Pages;

use App\Filament\Resources\Valoracions\ValoracionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditValoracion extends EditRecord
{
    protected static string $resource = ValoracionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
