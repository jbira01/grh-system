<?php

namespace App\Filament\Widgets;

use App\Models\Employe;
use App\Models\Paie;
use App\Models\Departement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    //  AJOUTEZ CETTE FONCTION POUR LA SÉCURITÉ 
    public static function canView(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Seul l'admin a le droit de voir ces statistiques globales
        return $user && $user->hasRole('admin');
    }

    protected function getStats(): array
    {
        // Calcul de la masse salariale du mois en cours
        $masseSalariale = Paie::where('mois', now()->month)
                              ->where('annee', now()->year)
                              ->sum('net_a_payer');

        return [
            Stat::make('Total Employés', Employe::count())
                ->description('Effectif actif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Masse Salariale', number_format($masseSalariale, 2) . ' DH')
                ->description('Net versé ce mois')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Départements', Departement::count())
                ->description('Services opérationnels')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('warning'),
        ];
    }
}
