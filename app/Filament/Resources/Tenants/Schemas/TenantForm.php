<?php

namespace App\Filament\Resources\Tenants\Schemas;

use App\Models\City;
use App\Models\State;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    FileUpload::make("logo")->previewable()->image()->imagePreviewHeight('100px')->columnSpanFull(),
                    TextInput::make('name')->label(__('Name'))
                        ->required()
                        ->live(true)
                        ->afterStateUpdated(function ($get, $set) {
                            $slug = str()->slug($get('name'));
                            $set('slug', $slug);
                        }),
                    TextInput::make('slug')->unique(ignoreRecord:true)->disabled()->dehydrated()->label(__('Slug')),
                    TextInput::make('domain')->unique(ignoreRecord:true)->label(__('Domain')),
                    TextInput::make('email')
                        ->label(__('Email'))
                        ->email(),
                    TextInput::make('phone')->label(__('Phone'))
                        ->tel(),
                    TextInput::make('website')->label(__('Website'))
                        ->url(),
                    Select::make('country_id')->label(__('Country'))
                        ->relationship("country", "name")
                        ->live()
                        ->afterStateUpdated(function ($set) {
                            $set('state_id', '');
                            $set('city_id', '');
                        }),
                    Select::make('state_id')->label(__('State'))
                        ->options(fn ($get) => State::when($get('country_id'), fn ($query) => $query->whereCountryId($get('country_id')))->pluck('name', 'id'))
                        ->live()
                        ->afterStateUpdated(function ($set) {
                            $set('city_id', '');
                        }),
                    Select::make('city_id')->label(__('City'))
                        ->options(fn ($get) => City::when($get('state_id'), fn ($query) => $query->whereStateId($get('state_id')))->pluck('name', 'id')),
                    TextInput::make('address')->label(__('Address')),
                    TextInput::make('linkedin')->label(__('Linkedin')),
                    TextInput::make('whatsapp')->label(__('Whatsapp')),
                    Textarea::make('about')->label(__('About'))
                        ->columnSpanFull(),
                    Toggle::make('is_active')->label(__('Is Active'))
                        ->required(),
                ])->columns(4)->columnSpanFull()
            ]);
    }
}
