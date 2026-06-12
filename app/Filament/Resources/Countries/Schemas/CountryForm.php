<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    FileUpload::make('flag')->columnSpanFull()->label(fn() => __("Flag")),
                    TextInput::make('name')->label(fn() => __("Name"))
                        ->required(),
                    TextInput::make('phone_code')->label(fn() => __("Phone Code"))
                        ->tel(),
                    TextInput::make('code')->label(fn() => __("Country Code")),
                    TextInput::make('gps')->label(fn() => __("Gps coordinators")),
                    TextInput::make('currency_name')->label(fn() => __("Currency Name")),
                    TextInput::make('currency_symbol')->label(fn() => __("Currency Name")),
                    TextInput::make('currency_code')->label(fn() => __("Currency Code")),
                    TextInput::make('timezone')->label(fn() => __("Timezone")),
                ])->columns(4)->columnSpanFull()
            ]);
    }
}
