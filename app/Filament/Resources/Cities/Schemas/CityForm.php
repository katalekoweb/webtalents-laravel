<?php

namespace App\Filament\Resources\Cities\Schemas;

use App\Models\Country;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Select::make('country_id')
                        ->required()
                        ->label(fn() => __('Country'))
                        ->live()
                        ->afterStateUpdated(function ($set) {
                            $set('state_id', "");
                        })
                        ->options(Country::pluck('name', 'id')),
                    Select::make('state_id')
                        ->required()
                        ->label(fn() => __('Country'))
                        ->options(fn ($get) =>
                            State::when($get('country_id'), fn ($query) => $query->whereCountryId($get('country_id')))->pluck('name', 'id')),
                    TextInput::make('name')->label(fn() => __('Name'))
                        ->required(),
                ])
            ]);
    }
}
