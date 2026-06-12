<?php

namespace App\Filament\Resources\States\Schemas;

use App\Models\Country;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Select::make('country_id')
                        ->required()
                        ->label(fn() => __('Country'))
                        ->options(Country::pluck('name', 'id')),
                    TextInput::make('name')->label(fn() => __('Name'))
                        ->required(),
                ])
            ]);
    }
}
