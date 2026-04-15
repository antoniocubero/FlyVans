<?php

namespace App\Filament\Resources\Fotos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FotoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_caravana')
                    ->required()
                    ->numeric(),
                TextInput::make('url')
                    ->url()
                    ->required(),
                Toggle::make('es_principal')
                    ->required(),
            ]);
    }
}
