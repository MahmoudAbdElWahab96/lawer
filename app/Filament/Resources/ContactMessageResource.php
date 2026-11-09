<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Width;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-inbox';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('الاستشارات');
    }

    public static function getModelLabel(): string
    {
        return __('طلب استشارة');
    }

    public static function getPluralModelLabel(): string
    {
        return __('طلبات الاستشارة');
    }

    public static function getNavigationLabel(): string
    {
        return __('طلبات الاستشارة');
    }

    public static function getNavigationBadge(): ?string
    {
        $count = ContactMessage::query()->where('is_read', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label(__('الحالة'))
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('الاسم'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('الهاتف'))
                    ->copyable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('نوع الاستشارة'))
                    ->state(fn (ContactMessage $record) => $record->practiceArea?->t('name'))
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('locale')
                    ->label(__('اللغة'))
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'ar' ? __('عربي') : 'EN'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('تاريخ الإرسال'))
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordUrl(null)
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label(__('الحالة'))
                    ->placeholder(__('الكل'))
                    ->trueLabel(__('مقروءة'))
                    ->falseLabel(__('جديدة'))
                    ->queries(
                        true: fn ($query) => $query->where('is_read', true),
                        false: fn ($query) => $query->where('is_read', false),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->actions([
                Actions\Action::make('view')
                    ->label(__('عرض'))
                    ->icon('heroicon-o-eye')
                    ->modalHeading(__('تفاصيل الرسالة'))
                    ->modalWidth(Width::TwoExtraLarge)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel(__('إغلاق'))
                    ->mountUsing(fn (ContactMessage $record) => $record->update(['is_read' => true]))
                    ->schema(fn (ContactMessage $record): array => [
                        Grid::make(['default' => 1, 'sm' => 2])->schema([
                            static::messageEntry('name', __('الاسم'), $record->name),
                            static::messageEntry('phone', __('رقم الهاتف'), new HtmlString('<bdi dir="ltr">'.e($record->phone).'</bdi>')),
                            static::messageEntry('email', __('البريد الإلكتروني'), $record->email ?: __('غير متوفر')),
                            static::messageEntry('created_at', __('تاريخ الإرسال'), $record->created_at->translatedFormat('j F Y - h:i A')),
                            static::messageEntry('practice_area', __('نوع الاستشارة'), $record->practiceArea?->t('name') ?? __('غير محدد')),
                        ]),
                        Section::make(__('نص الرسالة'))
                            ->compact()
                            ->schema([
                                TextEntry::make('message')
                                    ->hiddenLabel()
                                    ->state(new HtmlString(nl2br(e(trim($record->message)))))
                                    ->extraAttributes(['style' => 'line-height: 1.9;']),
                            ]),
                    ])
                    ->extraModalFooterActions(fn (ContactMessage $record): array => [
                        Actions\Action::make('callClient')
                            ->label(__('اتصال'))
                            ->icon('heroicon-o-phone')
                            ->url('tel:'.$record->phone),
                        Actions\Action::make('whatsappClient')
                            ->label(__('واتساب'))
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->color('success')
                            ->url('https://wa.me/'.preg_replace('/[^0-9]/', '', $record->phone), shouldOpenInNewTab: true),
                    ]),
                Actions\Action::make('toggleRead')
                    ->label(fn (ContactMessage $record) => $record->is_read ? __('تعليم كجديدة') : __('تعليم كمقروءة'))
                    ->icon(fn (ContactMessage $record) => $record->is_read ? 'heroicon-o-envelope' : 'heroicon-o-check')
                    ->action(fn (ContactMessage $record) => $record->update(['is_read' => ! $record->is_read]))
                    ->requiresConfirmation(),
                Actions\DeleteAction::make()->label(__('حذف')),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()->label(__('حذف المحدد')),
                ]),
            ])
            ->emptyStateHeading(__('لا توجد رسائل'))
            ->emptyStateDescription(__('رسائل فورم الاستشارة في الموقع تظهر هنا'));
    }

    protected static function messageEntry(string $name, string $label, string|HtmlString $state): TextEntry
    {
        return TextEntry::make($name)
            ->label($label)
            ->state($state)
            ->weight(FontWeight::SemiBold);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
        ];
    }
}
