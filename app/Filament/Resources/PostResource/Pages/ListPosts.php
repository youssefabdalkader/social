<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;


class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\PostResource\Widgets\PostsStats::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->badge(Post::count()),

            'published' => Tab::make('Published')
                ->modifyQueryUsing(fn($query) => $query->where('is_published', 1))
                ->badge(Post::where('is_published', 1)->count()),

            'draft' => Tab::make('Draft')
                ->modifyQueryUsing(fn($query) => $query->where('is_published', 0))
                ->badge(Post::where('is_published', 0)->count()),
        ];
    }
}
