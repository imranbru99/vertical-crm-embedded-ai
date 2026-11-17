<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use App\Models\NextBestAction;
use App\Models\PipelineScore;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CrmStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $openValue = (float) Deal::query()->where('status', 'open')->sum('amount');
        $avgScore = (float) Deal::query()->whereNotNull('ai_score')->avg('ai_score');

        return [
            Stat::make('Open Pipeline', '$'.number_format($openValue, 0))
                ->description('Active deal value')
                ->color('primary'),
            Stat::make('Avg AI Win Prob', number_format($avgScore, 1).'%')
                ->description('Across scored deals')
                ->color('success'),
            Stat::make('Scoring Runs', (string) PipelineScore::query()->count())
                ->description('Embedded AI scores')
                ->color('warning'),
            Stat::make('Open NBAs', (string) NextBestAction::query()->where('status', 'open')->count())
                ->description('Next-best actions')
                ->color('info'),
        ];
    }
}
