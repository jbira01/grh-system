<?php

namespace App\Filament\Resources\DossierEmployeResource\Pages;

use App\Filament\Resources\DossierEmployeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDossierEmployes extends ListRecords
{
    protected static string $resource = DossierEmployeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
