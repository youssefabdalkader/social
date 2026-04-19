<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Page;

class Dashboard extends BaseDashboard
{

    protected static ?string $navigationLabel = 'Home';

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('go to website')
                ->url(route('posts.index'))
        ];
    }
}