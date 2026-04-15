<?php

namespace App\Filament\Resources\Reservas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReservaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_usuario_reserva')
                    ->numeric()
                    ->default(null),
                TextInput::make('id_anuncio')
                    ->required()
                    ->numeric(),
                DatePicker::make('fecha_inicio')
                    ->required(),
                DatePicker::make('fecha_fin')
                    ->required(),
                Select::make('estado')
                    ->options(['pendiente' => 'Pendiente', 'confirmada' => 'Confirmada', 'cancelada' => 'Cancelada'])
                    ->default('pendiente')
                    ->required(),
                TextInput::make('coste')
                    ->required()
                    ->numeric(),
            ]);
    }
}
