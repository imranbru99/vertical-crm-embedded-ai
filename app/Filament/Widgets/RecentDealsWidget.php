<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentDealsWidget extends TableWidget
{
    protected static ?string $heading = 'Recent Deals';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Deal::query()->latest()->limit(8))
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('company.name')->label('Company'),
                TextColumn::make('stage.name')->badge(),
                TextColumn::make('amount')->money('USD'),
                TextColumn::make('ai_score')->badge()->color('primary'),
                TextColumn::make('status')->badge(),
            ])
            ->paginated(false);
    }
}
