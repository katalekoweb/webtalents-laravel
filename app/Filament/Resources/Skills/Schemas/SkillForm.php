<?php

namespace App\Filament\Resources\Skills\Schemas;

use App\Models\Skill;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 Section::make()->schema([
                    Select::make('parent_id')
                        ->required(false)
                        ->label(fn() => __('Parent'))
                        ->options(Skill::pluck('name', 'id')),
                    TextInput::make('name')->label(fn() => __('Name'))
                        ->required(),
                    Toggle::make("is_active")->default(true)->label(fn() => __('Is Active'))
                ])
            ]);
    }
}
