<?php

namespace App\Filament\Resources\PostLikes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PostLikeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Utilisateur')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('post_id')
                    ->label('Post')
                    ->relationship('post', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
