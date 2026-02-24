<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BulletinPaie extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function paie()
    {
        return $this->belongsTo(Paie::class);
    }

    // Lien vers le fichier physique
    public function fichier()
    {
        return $this->belongsTo(PieceJointe::class, 'piece_jointe_id');
    }
}