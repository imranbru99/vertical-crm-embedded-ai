<?php

namespace App\Filament\Resources\RevenueWorkflows;

use App\Filament\Resources\RevenueWorkflows\Pages\ManageRevenueWorkflows;
use App\Models\RevenueWorkflow;
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

class RevenueWorkflowResource extends Resource
{
    protected static ?string $model = RevenueWorkflow::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static string|UnitEnum|null $navigationGroup = 'Automation';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(\App\Services\ModuleManager::class)->enabled('revenue_workflows');
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
            TextInput::make('trigger_event')->default('stage_changed'),
            TextInput::make('vertical'),
            TextInput::make('sla_hours')->numeric()->default(48),
            Toggle::make('is_active')->default(true),
            TextInput::make('run_count')->numeric()->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('trigger_event'),
                TextColumn::make('vertical')->badge(),
                TextColumn::make('sla_hours'),
                IconColumn::make('is_active')->boolean(),
                TextColumn::make('run_count'),
                TextColumn::make('last_run_at')->dateTime()->toggleable(),
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
            'index' => ManageRevenueWorkflows::route('/'),
        ];
    }
}
