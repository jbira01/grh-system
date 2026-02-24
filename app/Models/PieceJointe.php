<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceJointe extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Cette méthode permet de récupérer le parent (Contrat, Employe, etc.)
    public function objet()
    {
        return $this->morphTo();
    }
    
    // Relation avec l'uploadeur
    public function uploadeur()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}