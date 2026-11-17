<?php

namespace App\Filament\Resources\PipelineScores;

use App\Filament\Resources\PipelineScores\Pages\ManagePipelineScores;
use App\Models\PipelineScore;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PipelineScoreResource extends Resource
{
    protected static ?string $model = PipelineScore::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'AI Insights';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(\App\Services\ModuleManager::class)->enabled('scoring_ai');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('deal_id')->relationship('deal','name')->required()->searchable(),
            TextInput::make('score')->numeric()->required(),
            TextInput::make('confidence')->numeric(),
            TextInput::make('model')->default('vertiq-score-v1'),
            Textarea::make('summary')->columnSpanFull(),
            DateTimePicker::make('scored_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('deal.name')->searchable(),
                TextColumn::make('score')->sortable()->badge(),
                TextColumn::make('confidence'),
                TextColumn::make('model')->toggleable(),
                TextColumn::make('scored_at')->dateTime(),
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
            'index' => ManagePipelineScores::route('/'),
        ];
    }
}
