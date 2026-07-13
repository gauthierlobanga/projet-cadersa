<?php

namespace App\Filament\Resources\NewsletterSends;

use App\Enums\NavigationGroup;
use App\Filament\Resources\NewsletterSends\Pages\ListNewsletterSends;
use App\Filament\Resources\NewsletterSends\Schemas\NewsletterSendForm;
use App\Filament\Resources\NewsletterSends\Tables\NewsletterSendsTable;
use App\Models\NewsletterSend;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class NewsletterSendResource extends Resource
{
    protected static ?string $model = NewsletterSend::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Share;

    protected static ?string $modelLabel = 'Envoi newsletter';

    protected static ?string $pluralModelLabel = 'Envois newsletters';

    protected static ?string $recordTitleAttribute = 'email';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return NewsletterSendForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsletterSendsTable::configure($table);
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
            'index' => ListNewsletterSends::route('/'),
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
