<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Conge extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
    
    // Petite fonction pour calculer la durée automatiquement
    public static function boot()
    {
        parent::boot();
        
        static::saving(function ($conge) {
            if ($conge->date_debut && $conge->date_fin) {
                // Calcul simple de la différence en jours
                $conge->jours = $conge->date_debut->diffInDays($conge->date_fin) + 1;
            }
        });
    }
}
