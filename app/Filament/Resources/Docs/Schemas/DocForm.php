<?php

namespace App\Filament\Resources\Docs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('name')->label(fn() => __('Name'))
                        ->required(),
                    Toggle::make("is_active")->default(true)->label(fn() => __('Is Active'))
                ])
            ]);
    }
}
