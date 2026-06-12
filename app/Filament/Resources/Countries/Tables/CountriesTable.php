<?php

namespace App\Filament\Resources\Countries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(fn () => __("Name"))
                    ->searchable(),
                ImageColumn::make('flag')->label(fn () => __("Flag"))
                    ->circular(),
                TextColumn::make('phone_code')->label(fn () => __("Phone code"))
                    ->searchable(),
                TextColumn::make('code')->label(fn () => __("Contry code"))
                    ->searchable(),
                TextColumn::make('gps')->label(fn () => __("Gps coordinators"))
                    ->searchable(),
                TextColumn::make('currency_name')->label(fn () => __("Currency Name"))->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('currency_symbol')->label(fn () => __("Currency Symbol"))->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('currency_code')->label(fn () => __("Currency Code"))->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('timezone')->label(fn () => __("Timezone"))
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
