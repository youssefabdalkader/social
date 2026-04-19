<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\ChartWidget;
use Spatie\Permission\Models\Role;

class RolesChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected int | string | array $columnSpan = 1;


    protected function getData(): array
    {
        $roles = Role::all();


        return [
            'datasets' => [
                [
                    'data' => $roles->map(function ($role) {
                        return $role->users()->count();
                    })->toArray(),
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
