<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poste extends Model
{
    use HasFactory;

    // 👇 Autorise tous les champs (titre, description, etc.)
    protected $guarded = [];
}