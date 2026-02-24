<?php

namespace App\Filament\Widgets;

use App\Models\Pointage;
use App\Models\Employe;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class PointageWidget extends Widget
{
    protected static string $view = 'filament.widgets.pointage-widget';
    
    // Prend toute la largeur de l'écran
    protected int | string | array $columnSpan = 'full';

    public ?Pointage $pointageDuJour = null;
    public ?Employe $employe = null;

    public function mount()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        
        if ($user && !$user->hasRole('admin')) {
            $this->employe = Employe::where('user_id', $user->id)->first();
            
            if ($this->employe) {
                // On cherche s'il a déjà pointé aujourd'hui
                $this->pointageDuJour = Pointage::where('employe_id', $this->employe->id)
                    ->where('date', Carbon::today())
                    ->first();
            }
        }
    }

    // Le widget n'est visible QUE pour les employés
    public static function canView(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        return $user && !$user->hasRole('admin');
    }

    public function pointerArrivee()
    {
        if (!$this->employe) return;

        $this->pointageDuJour = Pointage::create([
            'employe_id' => $this->employe->id,
            'date' => Carbon::today(),
            'heure_arrivee' => Carbon::now(),
        ]);

        Notification::make()
            ->title('Pointage réussi')
            ->body('Votre heure d\'arrivée a été enregistrée.')
            ->success()
            ->send();
    }

    public function pointerDepart()
    {
        if (!$this->employe || !$this->pointageDuJour) return;

        $this->pointageDuJour->update([
            'heure_depart' => Carbon::now(),
        ]);

        Notification::make()
            ->title('Pointage réussi')
            ->body('Votre heure de départ a été enregistrée. Bonne fin de journée !')
            ->success()
            ->send();
    }
}