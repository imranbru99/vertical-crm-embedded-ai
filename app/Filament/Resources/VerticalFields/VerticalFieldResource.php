<?php

namespace App\Filament\Resources\VerticalFields;

use App\Filament\Resources\VerticalFields\Pages\ManageVerticalFields;
use App\Models\VerticalField;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class VerticalFieldResource extends Resource
{
    protected static ?string $model = VerticalField::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|UnitEnum|null $navigationGroup = 'Configuration';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(\App\Services\ModuleManager::class)->enabled('vertical_fields');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('vertical')->required(),
            Select::make('entity_type')->options(['deal'=>'Deal','contact'=>'Contact','company'=>'Company'])->default('deal'),
            TextInput::make('field_key')->required(),
            TextInput::make('label')->required(),
            Select::make('field_type')->options(['text'=>'Text','number'=>'Number','select'=>'Select','boolean'=>'Boolean','date'=>'Date'])->default('text'),
            Toggle::make('is_required'),
            TextInput::make('sort_order')->numeric()->default(0),
            Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vertical')->badge(),
                TextColumn::make('entity_type'),
                TextColumn::make('field_key'),
                TextColumn::make('label'),
                TextColumn::make('field_type'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageVerticalFields::route('/'),
        ];
    }
}
