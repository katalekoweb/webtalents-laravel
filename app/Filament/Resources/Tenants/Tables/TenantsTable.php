<?php

namespace App\Filament\Resources\Tenants\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('Name'))->limit(16)
                    ->searchable(),
                TextColumn::make('slug')->label(__('Slug'))->limit(12)
                    ->searchable(),
                TextColumn::make('domain')->label(__('Domain'))->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('email')->label(__('Email'))
                    ->searchable(),
                TextColumn::make('phone')->label(__('Phone'))
                    ->searchable(),
                TextColumn::make('website')->label(__('Website'))->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('country.name')->label(__('Country'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('state.name')->label(__('State'))->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('city.name')->label(__('City'))->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('address')->label(__('Address'))->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('linkedin')->label(__('Linkedin'))->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('whatsapp')->label(__('Whatsapp'))
                    ->searchable(),
                IconColumn::make('is_active')->label(__('Is Active'))
                    ->boolean(),
                TextColumn::make('created_at')->label(fn () => __("Created at"))
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
                Action::make("vinculation")->label(function ($record) {
                    $user = request()->user();
                    return $user->tenant_id != $record->id ? __('Vinculate') : __('Remove');
                })->action(function ($record) {
                    $user = request()->user();
                    $user->tenant_id = $user->tenant_id === $record->id ? null : $record->id;
                    $user->save();
                })
                ->requiresConfirmation(),
                ViewAction::make(),
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
