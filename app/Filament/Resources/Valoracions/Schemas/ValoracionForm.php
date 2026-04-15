<?php

namespace App\Filament\Resources\Valoracions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ValoracionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_reserva')
                    ->required()
                    ->numeric(),
                TextInput::make('puntuacion')
                    ->required()
                    ->numeric(),
                Textarea::make('comentario')
                    ->default(null)
                    ->columnSpanFull(),
                DatePicker::make('fecha')
                    ->required(),
            ]);
    }
}
