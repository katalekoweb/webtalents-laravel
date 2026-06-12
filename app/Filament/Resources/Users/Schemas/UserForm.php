<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Country;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        $types = ['admin' => __('Admin'), 'manager' => __('Manager'), 'candidate' => __('Candidate')];

        if (request()->user()->type !== 'admin') {
            unset($types['admin']);
            unset($types['candidate']);
        }

        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('name')->label(fn () => __("Name"))
                        ->required(),
                    TextInput::make('email')
                        ->label(fn () => __("Email"))
                        ->email()
                        ->required(),
                    Select::make('country_code')->options(Country::pluck('name', 'phone_code'))->label(fn () => __("Country code")),
                    TextInput::make('phone')->label(fn () => __("Phone")),
                    Select::make('type')->label(fn () => __("User Type"))
                        ->options($types)
                        ->default('candidate')
                        ->required(),
                    DateTimePicker::make('email_verified_at')->label(fn () => __("Email verification"))
                ])
            ]);
    }
}
