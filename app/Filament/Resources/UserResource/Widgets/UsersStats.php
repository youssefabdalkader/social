<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class UsersStats extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Admins', User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->count())
                ->icon('heroicon-o-shield-check')
                ->color('danger'),

            Stat::make('Users', User::whereHas('roles', fn($q) => $q->where('name', 'User'))->count())
                ->icon('heroicon-o-user')
                ->color('success'),

            Stat::make('super admins', User::whereHas('roles', fn($q) => $q->where('name', 'super admin'))->count())
                ->icon('heroicon-o-shield-check')
                ->color('danger'),

            Stat::make('hr', User::whereHas('roles', fn($q) => $q->where('name', 'hr'))->count())
                ->icon('heroicon-o-user')
                ->color('success'),
        ];
    }
}
