<?php

namespace App\Filament\Resources\Docs;

use App\Filament\Resources\Docs\Pages\CreateDoc;
use App\Filament\Resources\Docs\Pages\EditDoc;
use App\Filament\Resources\Docs\Pages\ListDocs;
use App\Filament\Resources\Docs\Schemas\DocForm;
use App\Filament\Resources\Docs\Tables\DocsTable;
use App\Models\Doc;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

class DocResource extends Resource
{
    protected static ?string $model = Doc::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 7;

    #[Override]
    public static function getModelLabel(): string
    {
        return __("Document");
    }

    #[Override]
    public static function getPluralLabel(): ?string
    {
        return __("Documents");
    }

    #[Override]
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __("Settings");
    }

    public static function form(Schema $schema): Schema
    {
        return DocForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocs::route('/'),
            'create' => CreateDoc::route('/create'),
            'edit' => EditDoc::route('/{record}/edit'),
        ];
    }
}
