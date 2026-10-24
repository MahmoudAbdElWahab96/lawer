<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('markAllRead')
                ->label('تعليم الكل كمقروء')
                ->icon('heroicon-o-check-badge')
                ->action(fn () => ContactMessage::query()->where('is_read', false)->update(['is_read' => true]))
                ->requiresConfirmation(),
        ];
    }
}
