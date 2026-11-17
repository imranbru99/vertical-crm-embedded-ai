<?php

namespace App\Filament\Resources\ModuleSettings\Pages;

use App\Filament\Resources\ModuleSettings\ModuleSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageModuleSettings extends ManageRecords
{
    protected static string $resource = ModuleSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
