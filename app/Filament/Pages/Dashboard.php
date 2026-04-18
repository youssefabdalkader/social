<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PostsChart;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class, // فوق
        ];
    }

    public function getWidgets(): array
    {
        return [
            PostsChart::class, // تحت
        ];
    }
}
