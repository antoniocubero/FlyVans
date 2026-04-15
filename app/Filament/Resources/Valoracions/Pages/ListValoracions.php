<?php

namespace App\Filament\Resources\Valoracions\Pages;

use App\Filament\Resources\Valoracions\ValoracionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListValoracions extends ListRecords
{
    protected static string $resource = ValoracionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
