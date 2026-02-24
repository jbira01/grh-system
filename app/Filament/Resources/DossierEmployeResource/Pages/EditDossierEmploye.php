<?php

namespace App\Filament\Resources\DossierEmployeResource\Pages;

use App\Filament\Resources\DossierEmployeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDossierEmploye extends EditRecord
{
    protected static string $resource = DossierEmployeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
