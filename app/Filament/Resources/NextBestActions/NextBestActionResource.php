<?php

namespace App\Filament\Resources\NextBestActions;

use App\Filament\Resources\NextBestActions\Pages\ManageNextBestActions;
use App\Models\NextBestAction;
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

class NextBestActionResource extends Resource
{
    protected static ?string $model = NextBestAction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBolt;

    protected static string|UnitEnum|null $navigationGroup = 'AI Insights';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(\App\Services\ModuleManager::class)->enabled('next_best_actions');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('deal_id')->relationship('deal','name')->searchable(),
            Select::make('contact_id')->relationship('contact','email')->searchable(),
            Select::make('assigned_to')->relationship('assignee','name')->searchable(),
            Select::make('action_type')->options(['call'=>'Call','email'=>'Email','task'=>'Task','meeting'=>'Meeting'])->default('task'),
            TextInput::make('title')->required(),
            Textarea::make('rationale')->columnSpanFull(),
            Select::make('priority')->options(['low'=>'Low','medium'=>'Medium','high'=>'High'])->default('medium'),
            TextInput::make('impact_score')->numeric(),
            Select::make('status')->options(['open'=>'Open','done'=>'Done','dismissed'=>'Dismissed'])->default('open'),
            DateTimePicker::make('due_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('action_type')->badge(),
                TextColumn::make('priority')->badge(),
                TextColumn::make('impact_score')->sortable(),
                TextColumn::make('deal.name')->toggleable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('due_at')->dateTime(),
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
            'index' => ManageNextBestActions::route('/'),
        ];
    }
}
