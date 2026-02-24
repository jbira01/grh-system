<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paie extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Le cast permet de manipuler le JSON comme un tableau PHP automatiquement
    protected $casts = [
        'donnees_calcul' => 'array',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    // Une paie a un bulletin (PDF)
    public function bulletin()
    {
        return $this->hasOne(BulletinPaie::class);
    }
}