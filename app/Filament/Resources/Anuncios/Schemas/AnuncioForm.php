<?php

namespace App\Filament\Resources\Anuncios\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AnuncioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_caravana')
                    ->required()
                    ->numeric(),
                TextInput::make('titulo')
                    ->required(),
                Textarea::make('descripcion')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('precio_dia')
                    ->required()
                    ->numeric(),
                Select::make('estado')
                    ->options(['activo' => 'Activo', 'inactivo' => 'Inactivo'])
                    ->default('activo')
                    ->required(),
                TextInput::make('localizacion')
                    ->required(),
            ]);
    }
}
