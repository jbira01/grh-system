<?php

namespace App\Filament\Resources\PointageResource\Pages;

use App\Filament\Resources\PointageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

// 👇 Les deux lignes obligatoires pour Excel 👇
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListPointages extends ListRecords
{
    protected static string $resource = PointageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
            // 👇 Le bouton d'exportation vert 👇
            ExportAction::make()
                ->visible(function () {
                        /** @var \App\Models\User $user */
                        $user = Auth::user();
                        return $user && $user->hasRole('admin');
                    })
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => 'Pointages_' . date('Y-m-d'))
                ])
                ->label('Exporter vers Excel')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down'),
        ];
    }
}