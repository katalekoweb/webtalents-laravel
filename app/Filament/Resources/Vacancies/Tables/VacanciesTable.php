<?php

namespace App\Filament\Resources\Vacancies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VacanciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label(fn () => __("Title"))
                    ->searchable(),
                TextColumn::make('due_date')->label(fn () => __("Due date"))
                    ->date()
                    ->sortable(),
                TextColumn::make('country.name')->label(__('Country'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('state.name')->label(__('State'))->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('city.name')->label(__('City'))->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                IconColumn::make('only_in_place')->label(__('Allows candidate to move?'))
                    ->boolean(),
                IconColumn::make('is_remote')->label(__('Is remote?'))
                    ->boolean(),
                IconColumn::make('offer_visa')->label(__('Offer visa?'))
                    ->boolean(),
                IconColumn::make('is_published')->label(__('Is published?'))
                    ->boolean(),
                IconColumn::make('is_active')->label(__('Is active?'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label(fn () => __("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label(fn () => __("Updated at"))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
