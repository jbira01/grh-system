<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PointageResource\Pages;
use App\Filament\Resources\PointageResource\RelationManagers;
use App\Models\Pointage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PointageResource extends Resource
{
    protected static ?string $model = Pointage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('employe.matricule')
                ->label('Employé')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('date')
                ->date()
                ->sortable()
                ->label('Date'),
            Tables\Columns\TextColumn::make('heure_arrivee')
                ->time('H:i')
                ->label('Arrivée')
                ->badge()
                ->color('success'),
            Tables\Columns\TextColumn::make('heure_depart')
                ->time('H:i')
                ->label('Départ')
                ->badge()
                ->color('danger'),
        ])
        ->filters([
            // On peut filtrer par date par exemple
            Tables\Filters\Filter::make('date')
                ->form([
                    Forms\Components\DatePicker::make('date_debut'),
                    Forms\Components\DatePicker::make('date_fin'),
                ])
        ]);
}   

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPointages::route('/'),
            'create' => Pages\CreatePointage::route('/create'),
            'edit' => Pages\EditPointage::route('/{record}/edit'),
        ];
    }
    

    // 👇 AJOUTEZ CETTE FONCTION 👇
    public static function canViewAny(): bool
    {
        // Seuls les admins peuvent voir le menu et la liste des pointages
        return Auth::user()?->hasRole('admin') ?? false;
    }
}

