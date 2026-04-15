<?php

namespace App\Filament\Resources\Anuncios\Pages;

use App\Filament\Resources\Anuncios\AnuncioResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAnuncio extends EditRecord
{
    protected static string $resource = AnuncioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
