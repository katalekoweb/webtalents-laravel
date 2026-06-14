<?php

namespace App\Filament\Resources\Vacancies\RelationManagers;

use App\Models\Step;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Override;

class StepsRelationManager extends RelationManager
{
    protected static string $relationship = 'steps';

    protected function getTableHeading(): string|Htmlable|null
    {
        return __('Vacancy Steps');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('title')->label(fn() => __("Title"))
                        ->required(),
                    TextInput::make('order')->label(fn() => __("Order"))
                        ->required()
                        ->numeric()
                        ->default(1),
                    Textarea::make('decription')->label(fn() => __("Description"))
                        ->columnSpanFull(),
                    Toggle::make('is_current')->label(fn() => __("Is current"))
                        ->required(),
                    Toggle::make('is_finished')->label(fn() => __("Is finished"))
                        ->required(),
                    Toggle::make('is_active')->default(1)->label(fn() => __("Is active"))
                        ->required(),
                ])->columns(2)->columnSpanFull()
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')->label(fn() => __("Title")),
                TextEntry::make('order')->label(fn() => __("Order"))
                    ->numeric(),
                TextEntry::make('decription')->label(fn() => __("Description"))
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_finished')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn(Step $record): bool => $record->trashed()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('title')->label(fn() => __("Title"))
                    ->searchable(),
                TextColumn::make('order')->label(fn() => __("Order"))->numeric()->sortable(),
                ToggleColumn::make('is_current')->label(fn() => __("Is current")),
                IconColumn::make('is_finished')->label(fn() => __("Is finished"))->boolean(),
                IconColumn::make('is_active')->label(fn() => __("Is active"))
                    ->boolean(),
                TextColumn::make('created_at')->label(fn () => __("Created at"))->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->label(fn() => __("Updated at")),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
