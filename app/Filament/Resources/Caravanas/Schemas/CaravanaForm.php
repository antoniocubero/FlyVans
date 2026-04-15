<?php

namespace App\Filament\Resources\Caravanas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CaravanaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_usuario_propietario')
                    ->numeric()
                    ->default(null),
                TextInput::make('matricula')
                    ->required(),
                TextInput::make('marca')
                    ->required(),
                TextInput::make('modelo')
                    ->required(),
                TextInput::make('kilometraje')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('nota')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
