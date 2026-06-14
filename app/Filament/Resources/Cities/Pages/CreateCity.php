<?php

namespace App\Filament\Resources\Cities\Pages;

use App\Filament\Resources\Cities\CityResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;

    #[Override]
    protected function getRedirectUrl(): string
    {
        return parent::getResourceUrl('index');
    }
}
