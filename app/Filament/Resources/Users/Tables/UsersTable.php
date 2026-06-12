<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        $types = ['admin' => __('Admin'), 'manager' => __('Manager'), 'candidate' => __('Candidate')];

        if (request()->user()->type !== 'admin') {
            unset($types['admin']);
            unset($types['candidate']);
        }

        return $table
            ->columns([
                TextColumn::make('tenant.name')->label(fn () => __("Company"))->searchable(),
                TextColumn::make('name')->label(fn () => __("Name"))->searchable(),
                TextColumn::make('email')->label(fn () => __("Email"))->searchable(),
                TextColumn::make('country_code')->label(fn () => __("Country code"))->searchable(),
                TextColumn::make('phone')->label(fn () => __("Phone"))->searchable(),
                TextColumn::make('type')->label(fn () => __("Type"))->badge(),
                TextColumn::make('email_verified_at')->label(fn () => __("Email verified at"))->dateTime()->sortable(),
                TextColumn::make('created_at')->label(fn () => __("Created at"))->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->label(fn () => __("Created at")),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')->label(fn () => __("User Type"))
                        ->options($types), // ->default('candidate'),
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
