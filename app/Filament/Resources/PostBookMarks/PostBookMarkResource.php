<?php

namespace App\Filament\Resources\PostBookMarks;

use App\Filament\Clusters\Posts\PostsCluster;
use App\Filament\Resources\PostBookMarks\Pages\CreatePostBookMark;
use App\Filament\Resources\PostBookMarks\Pages\EditPostBookMark;
use App\Filament\Resources\PostBookMarks\Pages\ListPostBookMarks;
use App\Filament\Resources\PostBookMarks\Schemas\PostBookMarkForm;
use App\Filament\Resources\PostBookMarks\Tables\PostBookMarksTable;
use App\Models\PostBookMark;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PostBookMarkResource extends Resource
{
    protected static ?string $model = PostBookMark::class;

    protected static ?string $cluster = PostsCluster::class;

    protected static ?string $recordTitleAttribute = 'post_id';

    public static function form(Schema $schema): Schema
    {
        return PostBookMarkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostBookMarksTable::configure($table);
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
            'index' => ListPostBookMarks::route('/'),
            'create' => CreatePostBookMark::route('/create'),
            'edit' => EditPostBookMark::route('/{record}/edit'),
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
