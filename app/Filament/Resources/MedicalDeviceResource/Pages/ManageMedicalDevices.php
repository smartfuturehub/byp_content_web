<?php

namespace App\Filament\Resources\MedicalDeviceResource\Pages;

use App\Filament\Resources\MedicalDeviceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMedicalDevices extends ManageRecords
{
    protected static string $resource = MedicalDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
