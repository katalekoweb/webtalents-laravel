<?php

namespace App\Filament\Resources\Vacancies\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VacancyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID'),
                TextInput::make('creator_id')
                    ->numeric(),
                TextInput::make('tenant_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                DatePicker::make('due_date'),
                TextInput::make('country_id')
                    ->numeric(),
                TextInput::make('state_id')
                    ->numeric(),
                TextInput::make('city_id')
                    ->numeric(),
                Toggle::make('only_in_place')
                    ->required(),
                Toggle::make('is_remote')
                    ->required(),
                Toggle::make('offer_visa')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
