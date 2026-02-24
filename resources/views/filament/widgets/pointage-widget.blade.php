<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold">Pointage du jour</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ now()->translatedFormat('l d F Y') }}
                </p>
            </div>

            <div class="flex gap-4 items-center">
                {{-- BOUTON ARRIVÉE --}}
                @if(!$pointageDuJour || !$pointageDuJour->heure_arrivee)
                    <x-filament::button wire:click="pointerArrivee" color="success" icon="heroicon-o-arrow-right-end-on-rectangle">
                        Pointer mon arrivée
                    </x-filament::button>
                @else
                    <div class="text-sm px-4 py-2 bg-success-50 dark:bg-success-900/20 rounded-lg">
                        <span class="text-gray-500">Arrivée :</span> 
                        <span class="font-bold text-success-600 dark:text-success-400">{{ $pointageDuJour->heure_arrivee->format('H:i') }}</span>
                    </div>
                @endif

                {{-- BOUTON DÉPART --}}
                @if($pointageDuJour && $pointageDuJour->heure_arrivee && !$pointageDuJour->heure_depart)
                    <x-filament::button wire:click="pointerDepart" color="danger" icon="heroicon-o-arrow-left-start-on-rectangle">
                        Pointer mon départ
                    </x-filament::button>
                @elseif($pointageDuJour && $pointageDuJour->heure_depart)
                    <div class="text-sm px-4 py-2 bg-danger-50 dark:bg-danger-900/20 rounded-lg">
                        <span class="text-gray-500">Départ :</span> 
                        <span class="font-bold text-danger-600 dark:text-danger-400">{{ $pointageDuJour->heure_depart->format('H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>