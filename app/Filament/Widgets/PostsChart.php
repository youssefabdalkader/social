<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;

class PostsChart extends ChartWidget
{
    protected static ?string $heading = 'Posts Status';

    protected static ?int $sort = 2;


    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'data' => [
                        Post::where('is_published', 1)->count(), // Published
                        Post::where('is_published', 0)->count(), // Draft / Unpublished
                    ],
                ],
            ],

            'labels' => [
                'Published',
                'Draft',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
