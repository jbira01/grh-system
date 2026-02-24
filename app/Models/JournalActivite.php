<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalActivite extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'donnees_avant' => 'array',
        'donnees_apres' => 'array',
    ];

    public function objet()
    {
        return $this->morphTo();
    }
    
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}