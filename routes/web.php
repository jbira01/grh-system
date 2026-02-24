<?php

use App\Models\Paie;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/bulletin/{paie}', function (Paie $paie) {
    // On charge la vue avec les données de la paie
    $pdf = Pdf::loadView('pdf.bulletin', ['paie' => $paie]);
    
    // On lance le téléchargement
    return $pdf->download('Bulletin-'.$paie->employe->matricule.'-'.$paie->mois.'.pdf');
})->name('paie.pdf');