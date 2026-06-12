<?php

namespace App\Filament\Resources\Vacancies\Schemas;

use App\Models\City;
use App\Models\Skill;
use App\Models\State;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VacancyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Basic Information'))->collapsible()->schema([
                    TextInput::make('title')->columnSpanFull()->label(fn () => __("Title"))
                        ->required(),
                    Textarea::make('description')->label(fn () => __("Description"))
                        ->columnSpanFull(),
                    DatePicker::make('due_date')->label(fn () => __("Due date")),

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

                ])->columns(4)->columnSpanFull(),

                Section::make(__('Skills'))->collapsible()->collapsed()->schema([
                    Repeater::make('skills')->label("")->relationship("skills")->schema([
                        Select::make("skill_id")->options(Skill::orderBy('name')->pluck('name', 'id'))->required()->label(__('Skill')),
                        TextInput::make("min_experience_years")->label(__('Min years of experience'))->numeric()
                    ])->columns(2)->columnSpanFull()
                ])->columnSpanFull(),

                Section::make(__('States and status'))->collapsible()->collapsed()->schema([
                    Toggle::make('only_in_place')->label(__('Allows candidates to move?'))
                        ->required(),
                    Toggle::make('is_remote')->label(__('Is remote?'))
                        ->required(),
                    Toggle::make('offer_visa')->label(__('Offer visa?'))
                        ->required(),
                    Toggle::make('is_published')->label(__('Is published?'))
                        ->required(),
                    Toggle::make('is_active')->required()->default(true)->label(__('Is Active?')),
                ])->columns(5)->columnSpanFull()
            ]);
    }
}
