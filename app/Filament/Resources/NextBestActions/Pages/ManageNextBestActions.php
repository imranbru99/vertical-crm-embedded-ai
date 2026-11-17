<?php

namespace App\Filament\Resources\NextBestActions\Pages;

use App\Filament\Resources\NextBestActions\NextBestActionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageNextBestActions extends ManageRecords
{
    protected static string $resource = NextBestActionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
