<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-inbox';

    protected static \UnitEnum|null|string $navigationGroup = 'الاستشارات';

    protected static ?string $modelLabel = 'طلب استشارة';

    protected static ?string $pluralModelLabel = 'طلبات الاستشارة';

    protected static ?string $navigationLabel = 'طلبات الاستشارة';

    protected static ?int $navigationSort = 1;

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
                    ->label('الحالة')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف')
                    ->copyable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع الاستشارة')
                    ->state(fn (ContactMessage $record) => $record->practiceArea?->t('name'))
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('locale')
                    ->label('اللغة')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'ar' ? 'عربي' : 'EN'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordUrl(null)
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('الحالة')
                    ->placeholder('الكل')
                    ->trueLabel('مقروءة')
                    ->falseLabel('جديدة')
                    ->queries(
                        true: fn ($query) => $query->where('is_read', true),
                        false: fn ($query) => $query->where('is_read', false),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->actions([
                Actions\Action::make('view')
                    ->label('عرض')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('تفاصيل الرسالة')
                    ->modalContent(fn (ContactMessage $record) => view('filament.resources.contact-message', ['record' => $record]))
                    ->after(fn (ContactMessage $record) => $record->update(['is_read' => true])),
                Actions\Action::make('toggleRead')
                    ->label(fn (ContactMessage $record) => $record->is_read ? 'تعليم كجديدة' : 'تعليم كمقروءة')
                    ->icon(fn (ContactMessage $record) => $record->is_read ? 'heroicon-o-envelope' : 'heroicon-o-check')
                    ->action(fn (ContactMessage $record) => $record->update(['is_read' => ! $record->is_read]))
                    ->requiresConfirmation(),
                Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ])
            ->emptyStateHeading('لا توجد رسائل')
            ->emptyStateDescription('رسائل فورم الاستشارة في الموقع تظهر هنا');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
        ];
    }
}
