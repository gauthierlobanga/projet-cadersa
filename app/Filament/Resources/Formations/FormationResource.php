<?php

namespace App\Filament\Resources\Formations;

use App\Filament\Resources\Formations\Pages\CreateFormation;
use App\Filament\Resources\Formations\Pages\EditFormation;
use App\Filament\Resources\Formations\Pages\ListFormations;
use App\Filament\Resources\Formations\Schemas\FormationForm;
use App\Filament\Resources\Formations\Tables\FormationsTable;
use App\Models\Formation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class FormationResource extends Resource
{
    protected static ?string $model = Formation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Cadersa';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return FormationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormationsTable::configure($table);
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
            'index' => ListFormations::route('/'),
            'create' => CreateFormation::route('/create'),
            'edit' => EditFormation::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'success' : 'warning';
    }
}
