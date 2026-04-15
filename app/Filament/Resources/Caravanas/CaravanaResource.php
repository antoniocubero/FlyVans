<?php

namespace App\Filament\Resources\Caravanas;

use App\Filament\Resources\Caravanas\Pages\CreateCaravana;
use App\Filament\Resources\Caravanas\Pages\EditCaravana;
use App\Filament\Resources\Caravanas\Pages\ListCaravanas;
use App\Filament\Resources\Caravanas\Schemas\CaravanaForm;
use App\Filament\Resources\Caravanas\Tables\CaravanasTable;
use App\Models\Caravana;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CaravanaResource extends Resource
{
    protected static ?string $model = Caravana::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Caravanas';

    public static function form(Schema $schema): Schema
    {
        return CaravanaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CaravanasTable::configure($table);
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
            'index' => ListCaravanas::route('/'),
            'create' => CreateCaravana::route('/create'),
            'edit' => EditCaravana::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
