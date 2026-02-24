<?php

namespace App\Filament\Resources\PaieResource\Pages;

use App\Filament\Resources\PaieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaie extends EditRecord
{
    protected static string $resource = PaieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
