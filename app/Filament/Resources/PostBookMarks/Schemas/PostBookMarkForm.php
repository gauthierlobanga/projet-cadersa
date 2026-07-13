<?php

namespace App\Filament\Resources\PostBookMarks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PostBookMarkForm
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
