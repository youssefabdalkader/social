<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Like;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Posts', Post::count())
                ->icon('heroicon-o-document-text')
                ->color('danger'),

            Stat::make('Published', Post::where('is_published', 1)->count())
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('likes', Like::count())->color('info')->icon('heroicon-o-heart'),
        ];
    }
}
