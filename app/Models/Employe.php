<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    // Protection contre l'assignation de masse (sécurité)
    protected $guarded = [];

    // Un employé appartient à un User (compte de connexion)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un employé a un poste
    public function poste()
    {
        return $this->belongsTo(Poste::class);
    }

    // Un employé est dans un département
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    // Un employé a un dossier administratif
    public function dossier()
    {
        return $this->hasOne(DossierEmploye::class);
    }

    // Un employé peut avoir plusieurs contrats (historique)
    // Le dernier en date est le contrat actuel.
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    // Une petite astuce pour récupérer le contrat actuel directement
    public function contratActuel()
    {
        return $this->hasOne(Contrat::class)->latestOfMany();
    }

    public function paies()
    {
        return $this->hasMany(Paie::class);
    }

    public function primes()
    {
        return $this->hasMany(Prime::class);
    }

    // Formations suivies
    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'participation_formations')
                    ->withPivot('statut')
                    ->withTimestamps();
    }

    // Évaluations reçues
    public function evaluations()
    {
        return $this->hasMany(EvaluationPerformance::class);
    }

    // Sanctions
    public function sanctions()
    {
        return $this->hasMany(SanctionDisciplinaire::class);
    }

    // Historique de carrière
    public function historique()
    {
        return $this->hasMany(HistoriqueCarriere::class);
    }

    // Les candidatures internes faites par cet employé
    public function candidaturesInternes()
    {
        return $this->hasMany(RecrutementInterne::class);
    }
}