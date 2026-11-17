<?php

namespace App\Filament\Resources\Deals;

use App\Filament\Resources\Deals\Pages\ManageDeals;
use App\Models\Deal;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class DealResource extends Resource
{
    protected static ?string $model = Deal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static string|UnitEnum|null $navigationGroup = 'Pipeline';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(\App\Services\ModuleManager::class)->enabled('deals');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('slug')->required()->unique(ignoreRecord: true),
            Select::make('company_id')->relationship('company','name')->searchable(),
            Select::make('contact_id')->relationship('contact','email')->searchable(),
            Select::make('owner_id')->relationship('owner','name')->searchable(),
            Select::make('pipeline_stage_id')->relationship('stage','name')->searchable(),
            TextInput::make('amount')->numeric()->required(),
            TextInput::make('currency')->default('USD')->maxLength(3),
            DatePicker::make('expected_close_date'),
            TextInput::make('vertical'),
            Select::make('status')->options(['open'=>'Open','won'=>'Won','lost'=>'Lost'])->default('open'),
            Select::make('forecast_category')->options(['pipeline'=>'Pipeline','upside'=>'Upside','commit'=>'Commit','closed_won'=>'Closed Won']),
            TextInput::make('ai_score')->numeric()->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('company.name')->label('Company'),
                TextColumn::make('stage.name')->label('Stage')->badge(),
                TextColumn::make('amount')->money('USD')->sortable(),
                TextColumn::make('ai_score')->badge()->color('primary'),
                TextColumn::make('status')->badge(),
                TextColumn::make('owner.name')->toggleable(),
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
            'index' => ManageDeals::route('/'),
        ];
    }
}
