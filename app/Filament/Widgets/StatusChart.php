<?php


namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Spatie\Permission\Models\Role;

class StatusChart extends ChartWidget
{
    protected static ?string $heading = 'Users By Role';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $roles = Role::withCount('users')->get();

        return [
            'datasets' => [
                [
                    'data' => $roles->pluck('users_count')->toArray(),
                ],
            ],

            'labels' => $roles->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
