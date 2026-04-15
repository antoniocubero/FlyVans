<?php

namespace App\Filament\Resources\Valoracions;

use App\Filament\Resources\Valoracions\Pages\CreateValoracion;
use App\Filament\Resources\Valoracions\Pages\EditValoracion;
use App\Filament\Resources\Valoracions\Pages\ListValoracions;
use App\Filament\Resources\Valoracions\Schemas\ValoracionForm;
use App\Filament\Resources\Valoracions\Tables\ValoracionsTable;
use App\Models\Valoracion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ValoracionResource extends Resource
{
    protected static ?string $model = Valoracion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Valoraciones';

    public static function form(Schema $schema): Schema
    {
        return ValoracionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ValoracionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListValoracions::route('/'),
            'create' => CreateValoracion::route('/create'),
            'edit' => EditValoracion::route('/{record}/edit'),
        ];
    }
}
