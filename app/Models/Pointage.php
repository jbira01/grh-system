<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'heure_arrivee' => 'datetime',
        'heure_depart' => 'datetime',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}