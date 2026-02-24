<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName; // <--- AJOUT 1
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasName // <--- AJOUT 2
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'uuid', 'nom', 'prenom', 'email', 'telephone', 
        'photo_url', 'etat', 'derniere_connexion_at', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'derniere_connexion_at' => 'datetime',
        ];
    }
    
    public function employe()
    {
        return $this->hasOne(Employe::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    // <--- AJOUT 3 : La méthode qui sauve la situation
    public function getFilamentName(): string
    {
        return "{$this->prenom} {$this->nom}";
    }
}