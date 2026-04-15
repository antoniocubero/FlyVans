<?php

namespace App\Filament\Resources\Caravanas\Pages;

use App\Filament\Resources\Caravanas\CaravanaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCaravanas extends ListRecords
{
    protected static string $resource = CaravanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
