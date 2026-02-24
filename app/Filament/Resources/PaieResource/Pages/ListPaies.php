<?php

namespace App\Filament\Resources\PaieResource\Pages;

use App\Filament\Resources\PaieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaies extends ListRecords
{
    protected static string $resource = PaieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
