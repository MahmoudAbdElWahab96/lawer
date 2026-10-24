<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\PracticeArea;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Stats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('رسائل جديدة', ContactMessage::query()->where('is_read', false)->count())
                ->description('من فورم الاستشارة')
                ->descriptionIcon('heroicon-m-inbox')
                ->color(ContactMessage::query()->where('is_read', false)->exists() ? 'danger' : 'gray')
                ->url(\App\Filament\Resources\ContactMessageResource::getUrl()),
            Stat::make('إجمالي الرسائل', ContactMessage::query()->count())
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),
            Stat::make('مقالات منشورة', Article::query()->where('is_published', true)->count())
                ->description('من إجمالي ' . Article::query()->count())
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),
            Stat::make('مجالات الممارسة', PracticeArea::query()->where('is_active', true)->count())
                ->descriptionIcon('heroicon-m-scale')
                ->color('warning'),
        ];
    }
}
