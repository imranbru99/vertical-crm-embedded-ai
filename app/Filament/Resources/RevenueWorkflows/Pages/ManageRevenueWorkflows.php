<?php

namespace App\Filament\Resources\RevenueWorkflows\Pages;

use App\Filament\Resources\RevenueWorkflows\RevenueWorkflowResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRevenueWorkflows extends ManageRecords
{
    protected static string $resource = RevenueWorkflowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
