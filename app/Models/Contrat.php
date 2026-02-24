<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    // On autorise tous les champs (salaire, dates, etc.)
    protected $guarded = [];

    // 👇 C'est cette méthode qui manquait à Filament !
    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}