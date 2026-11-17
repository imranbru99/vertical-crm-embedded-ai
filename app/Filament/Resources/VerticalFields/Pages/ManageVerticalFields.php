<?php

namespace App\Filament\Resources\VerticalFields\Pages;

use App\Filament\Resources\VerticalFields\VerticalFieldResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageVerticalFields extends ManageRecords
{
    protected static string $resource = VerticalFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
