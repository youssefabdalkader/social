<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {

        return [

            Stat::make('Total Users', User::count()),

            Stat::make('Total Posts', Post::count()),

            Stat::make('Total comments', Comment::count()),

            Stat::make('Total likes', Like::count()),

            Stat::make(
                'Total Roles',
                \Spatie\Permission\Models\Role::count()
            ),

        ];
    }
}
