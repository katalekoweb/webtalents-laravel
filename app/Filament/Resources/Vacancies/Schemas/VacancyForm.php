<?php

namespace App\Filament\Resources\Vacancies\Schemas;

use App\Models\City;
use App\Models\Skill;
use App\Models\Language;
use App\Models\Doc;
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
        $levels = [
            'basic' => __('Basic'),
            'intermediate' => __('Intermediate'),
            'advanced' => __('Advanced'),
            'native' => __('Native')
        ];

        return $schema
            ->components([
                Section::make(__('Basic Information'))->collapsible()->collapsed()->schema([
                    TextInput::make('title')->columnSpanFull()->label(fn() => __("Title"))
                        ->required(),
                    Textarea::make('description')->label(fn() => __("Description"))
                        ->columnSpanFull(),
                    DatePicker::make('due_date')->label(fn() => __("Due date")),

                    Select::make('country_id')->label(__('Country'))
                        ->relationship("country", "name")
                        ->live()
                        ->afterStateUpdated(function ($set) {
                            $set('state_id', '');
                            $set('city_id', '');
                        }),
                    Select::make('state_id')->label(__('State'))
                        ->options(fn($get) => State::when($get('country_id'), fn($query) => $query->whereCountryId($get('country_id')))->pluck('name', 'id'))
                        ->live()
                        ->afterStateUpdated(function ($set) {
                            $set('city_id', '');
                        }),
                    Select::make('city_id')->label(__('City'))
                        ->options(fn($get) => City::when($get('state_id'), fn($query) => $query->whereStateId($get('state_id')))->pluck('name', 'id')),

                ])->columns(4)->columnSpanFull(),

                Section::make(__('Salary range'))->schema([
                    TextInput::make("min_salary")->label(__('Min salary'))->numeric(),
                    TextInput::make("max_salary")->label(__('Max salary'))->numeric()
                ])->columns(2)->columnSpanFull()->collapsible()->collapsed(),

                Section::make(__('Skills'))->collapsible()->collapsed()->schema([
                    Repeater::make('skills')->label("")->relationship("skills")->schema([
                        Select::make("skill_id")->disableOptionsWhenSelectedInSiblingRepeaterItems()->options(Skill::orderBy('name')->pluck('name', 'id'))->required()->label(__('Skill')),
                        TextInput::make("min_experience_years")->label(__('Min years of experience'))->numeric(),
                        Toggle::make('is_required')->label(__('Required?'))->required(),
                    ])->columns(3)->columnSpanFull()
                ])->columnSpanFull(),

                Section::make(__('Languages'))->collapsible()->collapsed()->schema([
                    Repeater::make('languages')->label("")->relationship("languages")->schema([
                        Select::make("language_id")->disableOptionsWhenSelectedInSiblingRepeaterItems()->options(Language::orderBy('name')->pluck('name', 'id'))->required()->label(__('Language')),
                        Select::make("level")->options($levels)->required()->label(__('Level')),
                        Toggle::make('is_required')->label(__('Required?'))->required(),
                    ])->columns(3)->columnSpanFull()
                ])->columnSpanFull(),

                Section::make(__('Aditional docs'))->collapsible()->collapsed()->schema([
                    Repeater::make('docs')->label("")->relationship("docs")->schema([
                        Select::make("doc_id")->disableOptionsWhenSelectedInSiblingRepeaterItems()->options(Doc::orderBy('name')->pluck('name', 'id'))->required()->label(__('Document')),
                        Toggle::make('is_required')->label(__('Required?'))->required(),
                    ])->columns(2)->columnSpanFull()
                ])->columnSpanFull(),

                Section::make(__('Age relevance'))->collapsible()->collapsed()->schema([
                        Toggle::make('is_age_relevant')->live()->label(__('Is age relevant?'))->required()->columnSpanFull(),
                        Select::make("priority")
                        ->visible(fn ($get) => (int)$get('is_age_relevant') == 1)
                        ->options([
                            'younger' => __('Youngs'),
                            'older' => __('Olders')
                        ])->required()->label(__('Age priority')),
                        TextInput::make("age_weight")->visible(fn ($get) => (int)$get('is_age_relevant') == 1)->label(__('Age weight in percent'))->numeric(),
                ])->columnSpanFull()->columns(2),

                Section::make(__('States and status'))->collapsible()->collapsed()->schema([
                    Toggle::make('only_for_woman')->label(__('Only for womans?'))->required(),
                    Toggle::make('only_for_pwd')->label(__('Only for people with deficiency?'))->required(),

                    Toggle::make('only_in_place')->label(__('Allows candidates to move?'))
                        ->required(),
                    Toggle::make('is_remote')->label(__('Is remote?'))->required(),
                    Toggle::make('offer_visa')->label(__('Offer visa?'))
                        ->required(),

                    Toggle::make('receiving_applies')->label(__('Open for new applies?'))->required(),
                    Toggle::make('is_published')->label(__('Is published?'))
                        ->required(),
                    Toggle::make('is_active')->required()->default(true)->label(__('Is Active?')),
                ])->columns(5)->columnSpanFull()
            ]);
    }
}
