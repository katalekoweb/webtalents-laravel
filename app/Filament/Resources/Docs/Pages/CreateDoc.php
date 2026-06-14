<?php

namespace App\Filament\Resources\Docs\Pages;

use App\Filament\Resources\Docs\DocResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDoc extends CreateRecord
{
    protected static string $resource = DocResource::class;

    protected function getRedirectUrl(): string
    {
        return parent::getResourceUrl('index');
    }
}
