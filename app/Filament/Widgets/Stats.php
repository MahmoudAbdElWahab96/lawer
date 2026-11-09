<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\PracticeArea;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Stats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(__('طلبات جديدة'), ContactMessage::query()->where('is_read', false)->count())
                ->description(__('من فورم حجز الاستشارة'))
                ->descriptionIcon('heroicon-m-inbox')
                ->color(ContactMessage::query()->where('is_read', false)->exists() ? 'danger' : 'gray')
                ->url(ContactMessageResource::getUrl()),
            Stat::make(__('إجمالي الطلبات'), ContactMessage::query()->count())
                ->description(__('جميع الاستشارات المستلمة'))
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),
            Stat::make(__('مجالات الممارسة'), PracticeArea::query()->where('is_active', true)->count())
                ->description(__('المعروضة في صفحة الموقع'))
                ->descriptionIcon('heroicon-m-scale')
                ->color('warning'),
            Stat::make(__('الأسئلة الشائعة'), Faq::query()->where('is_active', true)->count())
                ->description(__('المعروضة في قسم الأسئلة'))
                ->descriptionIcon('heroicon-m-question-mark-circle')
                ->color('success'),
        ];
    }
}
