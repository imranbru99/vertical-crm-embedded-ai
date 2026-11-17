<?php

namespace App\Filament\Resources\PipelineScores\Pages;

use App\Filament\Resources\PipelineScores\PipelineScoreResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePipelineScores extends ManageRecords
{
    protected static string $resource = PipelineScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
