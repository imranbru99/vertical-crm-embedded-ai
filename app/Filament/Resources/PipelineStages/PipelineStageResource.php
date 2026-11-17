<?php

namespace App\Filament\Resources\PipelineStages;

use App\Filament\Resources\PipelineStages\Pages\ManagePipelineStages;
use App\Models\PipelineStage;
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

class PipelineStageResource extends Resource
{
    protected static ?string $model = PipelineStage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static string|UnitEnum|null $navigationGroup = 'Pipeline';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(\App\Services\ModuleManager::class)->enabled('pipeline');
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
            TextInput::make('position')->numeric()->required()->default(0),
            TextInput::make('probability_pct')->numeric()->required()->default(0),
            Toggle::make('is_won'),
            Toggle::make('is_lost'),
            TextInput::make('color')->default('#4F46E5'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('position')->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('probability_pct')->suffix('%'),
                IconColumn::make('is_won')->boolean(),
                IconColumn::make('is_lost')->boolean(),
                TextColumn::make('color'),
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
            'index' => ManagePipelineStages::route('/'),
        ];
    }
}
