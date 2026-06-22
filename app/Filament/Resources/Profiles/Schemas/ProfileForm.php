<?php

namespace App\Filament\Resources\Profiles\Schemas;

use App\Models\City;
use App\Models\Language;
use App\Models\Skill;
use App\Models\State;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfileForm
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
                Section::make(__('Basic Informations'))->collapsible()->collapsed()->schema([
                    FileUpload::make('photo')->imageEditor()->columnSpanFull(),
                    Select::make('user_id')->label(fn () => __('Candidate'))->required()->relationship('user', 'name', function ($query) {
                            $query->whereType('candidate');
                        })
                        ->createOptionForm([
                            TextInput::make('name')->label(fn() => __("Name"))
                                ->required(),
                            TextInput::make('email')
                                ->label(fn() => __("Email"))
                                ->email()
                                ->required(),
                        ]),
                    TextInput::make('title')
                        ->required(),
                    TextInput::make('email')->label(fn () => __('Email'))->email(),
                    Select::make('gender')->options([
                        'male' => __('Male'),
                        'female' => __('Female')
                    ])->label(fn () => __('Gender')),
                    DatePicker::make('dob')->label(fn () => __('Dob')),
                    TextInput::make('phone')->label(fn () => __('Phone')),
                    TextInput::make('whatsapp')->label(fn () => __('Whatsapp')),
                    Textarea::make('about')->columnSpanFull()->label(fn () => __('Summary')),

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

                    TextInput::make('address')->label(fn () => __('Address')),
                    TextInput::make('website')->label(fn () => __('Website/Portfolio'))->url(),
                    TextInput::make('linkedin')->label(fn () => __('Linkedin')),
                    Select::make('lang')->required()->options(Language::pluck('name', 'id'))->label(fn () => __('Profile Language')),
                    TextInput::make('order')->label(fn () => __('Order'))
                        ->required()
                        ->numeric()
                        ->default(1),
                    TextInput::make('min_salary')->label(fn () => __('Min salary'))
                        ->numeric()
                        ->columnSpan(1)
                        ->default(0.0),
                    Select::make('contract_type')->label(fn () => __('Contract type'))->nullable()->options([]),
                    // Toggle::make('is_human')
                    //     ->required(),
                ])->columns(5)->columnSpanFull(),

                Section::make(__('Skills'))->collapsible()->collapsed()->schema([
                    Repeater::make("skills")->relationship('skills')->schema([
                        Select::make("skill_id")->required()->options(Skill::pluck('name', 'id'))->label(fn () => __('Skill')),
                        TextInput::make("experience_years")->required()->numeric()->maxValue(70)->hint('Max 70. rsrsrsrs')->label(fn () => __('Experience years'))
                    ])->columns(2)
                ])->columnSpanFull(),

                Section::make(__('Education'))->collapsible()->collapsed()->schema([
                    Repeater::make("academics")->relationship('academics')->schema([
                        TextInput::make("title")->required()->label(fn () => __('Title')),
                        TextInput::make("school")->required()->label(fn () => __('Institution')),
                        TextInput::make("degree")->required()->label(fn () => __('Degree')),
                        Textarea::make("about")->required(false)->columnSpanFull()->label(fn () => __('Details')),
                        Toggle::make("current_here")->live()->required()->columnSpanFull()->label(fn () => __('Currently here')),
                        DatePicker::make('start_date')->required()->label(fn () => __('Start date')),
                        DatePicker::make('finish_date')->visible(fn ($get) => (int)$get('current_here') != 1)->label(fn () => __('Finish date'))->required(),
                    ])->columns(3)
                ])->columnSpanFull(),

                Section::make(__('Professional Experiencee'))->collapsible()->collapsed()->schema([
                    Repeater::make("experiences")->relationship('experiences')->schema([
                        TextInput::make("title")->required()->label(fn () => __('Title')),
                        TextInput::make("company")->required()->label(fn () => __('Company')),
                        TextInput::make("key_skills")->required()->label(fn () => __('Key skills')),
                        Textarea::make("about")->required(false)->columnSpanFull()->label(fn () => __('Details')),
                        Toggle::make("current_here")->live()->required()->columnSpanFull()->label(fn () => __('Currently here')),
                        DatePicker::make('start_date')->required()->label(fn () => __('Start date')),
                        DatePicker::make('finish_date')->visible(fn ($get) => (int)$get('current_here') != 1)->required()->label(fn () => __('End date')),
                    ])->columns(3)
                ])->columnSpanFull(),

                Section::make(__('Languages'))->collapsible()->collapsed()->schema([
                    Repeater::make("languages")->relationship('languages')->schema([
                        Select::make("language_id")->required()->options(Language::pluck('name', 'id'))->label(fn () => __('Language')),
                        Select::make("level")->options($levels)->required()->label(fn () => __('Fluency Level'))
                    ])->columns(2)
                ])->columnSpanFull(),

                Section::make(__('Status'))->schema([
                    Toggle::make('available')->label(fn () => __('Currently available'))->default(1),
                    Toggle::make('auto_apply')->label(fn () => __('Auto Apply'))->default(0),
                    Toggle::make('only_remote')->label(fn () => __('Only remote work')),
                    Toggle::make('iam_pwd')->label(fn () => __('Person with deficiency')),
                    Toggle::make('is_default')->label(fn () => __('Is default profile'))->required(),
                    Toggle::make('is_active')->default(1)->label(fn () => __('Is active'))->required(),
                ])->columns(3)->columnSpanFull()

            ]);
    }
}
