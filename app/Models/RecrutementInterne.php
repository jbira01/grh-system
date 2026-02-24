<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecrutementInterne extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relation : Quel est le poste visé ?
    public function poste()
    {
        return $this->belongsTo(Poste::class);
    }

    // Relation : Qui est le candidat ?
    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}