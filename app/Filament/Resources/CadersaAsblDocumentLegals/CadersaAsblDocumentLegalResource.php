<?php

namespace App\Filament\Resources\CadersaAsblDocumentLegals;

use App\Enums\NavigationGroup;
use App\Filament\Resources\CadersaAsblDocumentLegals\Pages\CreateCadersaAsblDocumentLegal;
use App\Filament\Resources\CadersaAsblDocumentLegals\Pages\EditCadersaAsblDocumentLegal;
use App\Filament\Resources\CadersaAsblDocumentLegals\Pages\ListCadersaAsblDocumentLegals;
use App\Filament\Resources\CadersaAsblDocumentLegals\Schemas\CadersaAsblDocumentLegalForm;
use App\Filament\Resources\CadersaAsblDocumentLegals\Tables\CadersaAsblDocumentLegalsTable;
use App\Models\CadersaAsblDocumentLegal;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CadersaAsblDocumentLegalResource extends Resource
{
    protected static ?string $model = CadersaAsblDocumentLegal::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Organisation;

    protected static ?string $recordTitleAttribute = 'numero_document';

    protected static ?string $navigationLabel = 'Document Légal';

    public static function form(Schema $schema): Schema
    {
        return CadersaAsblDocumentLegalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CadersaAsblDocumentLegalsTable::configure($table);
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
            'index' => ListCadersaAsblDocumentLegals::route('/'),
            'create' => CreateCadersaAsblDocumentLegal::route('/create'),
            'edit' => EditCadersaAsblDocumentLegal::route('/{record}/edit'),
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

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'success' : 'danger';
    }
}
