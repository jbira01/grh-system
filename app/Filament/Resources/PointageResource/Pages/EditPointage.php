<?php

namespace App\Filament\Resources\PointageResource\Pages;

use App\Filament\Resources\PointageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPointage extends EditRecord
{
    protected static string $resource = PointageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
