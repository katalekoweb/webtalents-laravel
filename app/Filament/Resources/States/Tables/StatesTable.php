<?php

namespace App\Filament\Resources\States\Tables;

use App\Models\Country;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('country.name')
                    ->label(fn () => __('Country'))
                    ->sortable(),
                TextColumn::make('name')->label(fn () => __('Name'))
                    ->searchable(),
                TextColumn::make('created_at')->label(fn () => __("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)->label(fn () => __("Updated at")),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('country_id')
                    ->label(fn() => __('Country'))
                    ->options(Country::pluck('name', 'id')),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
