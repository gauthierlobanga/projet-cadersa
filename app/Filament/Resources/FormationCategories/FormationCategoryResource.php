<?php

namespace App\Filament\Resources\FormationCategories;

use App\Filament\Resources\FormationCategories\Pages\CreateFormationCategory;
use App\Filament\Resources\FormationCategories\Pages\EditFormationCategory;
use App\Filament\Resources\FormationCategories\Pages\ListFormationCategories;
use App\Filament\Resources\FormationCategories\Schemas\FormationCategoryForm;
use App\Filament\Resources\FormationCategories\Tables\FormationCategoriesTable;
use App\Models\FormationCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FormationCategoryResource extends Resource
{
    protected static ?string $model = FormationCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Cadersa';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return FormationCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormationCategoriesTable::configure($table);
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
            'index' => ListFormationCategories::route('/'),
            'create' => CreateFormationCategory::route('/create'),
            'edit' => EditFormationCategory::route('/{record}/edit'),
        ];
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
