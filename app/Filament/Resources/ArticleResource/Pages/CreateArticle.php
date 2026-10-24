<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['cover_path'] = data_get($data, 'cover_path.0');

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return ArticleResource::getUrl('index');
    }
}
