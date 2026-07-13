<?php

namespace App\Filament\Resources\PostLikes;

use App\Filament\Clusters\Posts\PostsCluster;
use App\Filament\Resources\PostLikes\Pages\CreatePostLike;
use App\Filament\Resources\PostLikes\Pages\EditPostLike;
use App\Filament\Resources\PostLikes\Pages\ListPostLikes;
use App\Filament\Resources\PostLikes\Schemas\PostLikeForm;
use App\Filament\Resources\PostLikes\Tables\PostLikesTable;
use App\Models\PostLike;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PostLikeResource extends Resource
{
    protected static ?string $model = PostLike::class;

    protected static ?string $cluster = PostsCluster::class;

    protected static ?string $recordTitleAttribute = 'post_id';

    public static function form(Schema $schema): Schema
    {
        return PostLikeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostLikesTable::configure($table);
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
            'index' => ListPostLikes::route('/'),
            'create' => CreatePostLike::route('/create'),
            'edit' => EditPostLike::route('/{record}/edit'),
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
