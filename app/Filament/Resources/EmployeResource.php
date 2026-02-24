<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeResource\Pages;
use App\Models\Employe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group'; // Icône plus adaptée
    
    protected static ?string $navigationGroup = 'Gestion RH'; // Pour grouper dans le menu
    
    protected static ?string $recordTitleAttribute = 'matricule';

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // On vérifie s'il y a un utilisateur connecté ET s'il est admin
        return $user && $user->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informations Personnelles')
                    ->description('Lier cet employé à un compte utilisateur existant.')
                    ->schema([
                        // Sélection du compte User (Affiche l'email pour être unique)
                        Select::make('user_id')
                            ->relationship('user', 'email')
                            ->label('Compte Utilisateur')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([ // Permet de créer un User à la volée
                                TextInput::make('nom')->required(),
                                TextInput::make('prenom')->required(),
                                TextInput::make('email')->email()->required(),
                                TextInput::make('password')->password()->required(),
                            ]),

                        TextInput::make('matricule')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Affectation & Poste')
                    ->schema([
                        // Sélection du Département
                        Select::make('departement_id')
                            ->relationship('departement', 'libelle')
                            ->label('Département')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('code')->required()->label('Code (ex: RH)'),
                                TextInput::make('libelle')->required(),
                            ]),

                        // Sélection du Poste
                        Select::make('poste_id')
                            ->relationship('poste', 'titre')
                            ->label('Poste Occupé')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('titre')->required(),
                                TextInput::make('description'),
                            ]),

                        DatePicker::make('date_embauche')
                            ->label('Date d\'embauche')
                            ->required()
                            ->native(false) // Utilise le calendrier JS de Filament
                            ->displayFormat('d/m/Y'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Affiche le Nom via la relation User
                TextColumn::make('user.nom')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                // Affiche le Prénom via la relation User
                TextColumn::make('user.prenom')
                    ->label('Prénom')
                    ->searchable(),

                TextColumn::make('matricule')
                    ->badge() // Style badge gris
                    ->searchable(),

                // Affiche le libellé du département au lieu de l'ID
                TextColumn::make('departement.libelle')
                    ->label('Département')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                // Affiche le titre du poste au lieu de l'ID
                TextColumn::make('poste.titre')
                    ->label('Poste')
                    ->sortable(),

                TextColumn::make('date_embauche')
                    ->date('d/m/Y')
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filtre pour trier rapidement par département
                SelectFilter::make('departement')
                    ->relationship('departement', 'libelle')
                    ->label('Filtrer par Département'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // On pourra ajouter les Contrats ici plus tard
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployes::route('/'),
            'create' => Pages\CreateEmploye::route('/create'),
            'edit' => Pages\EditEmploye::route('/{record}/edit'),
        ];
    }
}