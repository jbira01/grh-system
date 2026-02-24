<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CongeResource\Pages;
use App\Models\Conge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class CongeResource extends Resource
{
    protected static ?string $model = Conge::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Gestion RH';
    protected static ?string $navigationLabel = 'Congés & Absences';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Demande')
                    ->schema([
                        Select::make('employe_id')
                            ->relationship('employe', 'matricule')
                            ->label('Employé')
                            ->searchable()
                            ->preload()
                            ->required()
                            // Sélection automatique de l'employé connecté
                            ->default(function () {
                                /** @var \App\Models\User|null $user */
                                $user = \Illuminate\Support\Facades\Auth::user();
                                
                                // Si c'est un employé normal, on trouve son ID d'employé
                                if ($user && !$user->hasRole('admin')) {
                                    return \App\Models\Employe::where('user_id', $user->id)->value('id');
                                }
                                return null;
                            })
                            // Griser le champ pour les employés (mais pas pour l'admin)
                            ->disabled(function () {
                                /** @var \App\Models\User|null $user */
                                $user = \Illuminate\Support\Facades\Auth::user();
                                return $user && !$user->hasRole('admin');
                            })
                            ->dehydrated(),

                        Select::make('type')
                            ->options([
                                'paye' => 'Congé Payé',
                                'maladie' => 'Maladie',
                                'sans_solde' => 'Sans Solde',
                                'maternite' => 'Maternité',
                                'recuperation' => 'Récupération',
                            ])
                            ->required(),

                        DatePicker::make('date_debut')->required(),
                        DatePicker::make('date_fin')->required()
                            ->afterOrEqual('date_debut'), // Validation logique
                            
                        Textarea::make('motif')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Validation Administration')
                    ->schema([
                        Select::make('statut')
                            ->options([
                                'en_attente' => 'En attente',
                                'accepte' => 'Accepté',
                                'refuse' => 'Refusé',
                            ])
                            ->default('en_attente')
                            ->required()
                            ->native(false),

                        Textarea::make('commentaire_admin')
                            ->label('Note administrative')
                            ->placeholder('Raison du refus ou détails...'),
                    ])->columns(2)
                    ->visible(function () {
                        /** @var \App\Models\User|null $user */
                        $user = \Illuminate\Support\Facades\Auth::user();
                        return $user && $user->hasRole('admin');
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employe.user.nom')
                    ->label('Employé')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paye' => 'success',
                        'maladie' => 'danger',
                        'sans_solde' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('date_debut')->date('d/m/Y')->label('Début'),
                TextColumn::make('date_fin')->date('d/m/Y')->label('Fin'),
                TextColumn::make('jours')->suffix(' Jours')->label('Durée'),

                TextColumn::make('statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'accepte' => 'success',
                        'refuse' => 'danger',
                        'en_attente' => 'warning',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'accepte' => 'heroicon-o-check-circle',
                        'refuse' => 'heroicon-o-x-circle',
                        'en_attente' => 'heroicon-o-clock',
                    }),
            ])
            ->filters([
                SelectFilter::make('statut')
                    ->options([
                        'en_attente' => 'En attente',
                        'accepte' => 'Validés',
                        'refuse' => 'Refusés',
                    ]),
            ])
            ->actions([
                // Bouton Valider (Vert) avec confirmation en Français
                Tables\Actions\Action::make('valider')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Valider le congé')
                    ->modalDescription('Êtes-vous sûr de vouloir valider cette demande de congé ?')
                    ->modalSubmitActionLabel('Oui, valider')
                    ->modalCancelActionLabel('Annuler')
                    ->action(fn (Conge $record) => $record->update(['statut' => 'accepte']))
                    // 👇 MISE À JOUR : Visibilité réservée aux admins
                    ->visible(function (Conge $record) {
                        /** @var \App\Models\User|null $user */
                        $user = \Illuminate\Support\Facades\Auth::user();
                        return $record->statut === 'en_attente' && $user && $user->hasRole('admin');
                    }),

                // Bouton Refuser (Rouge) avec confirmation en Français
                Tables\Actions\Action::make('refuser')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Refuser le congé')
                    ->modalDescription('Êtes-vous sûr de vouloir refuser cette demande ?')
                    ->modalSubmitActionLabel('Oui, refuser')
                    ->modalCancelActionLabel('Annuler')
                    ->action(fn (Conge $record) => $record->update(['statut' => 'refuse']))
                    // 👇 MISE À JOUR : Visibilité réservée aux admins
                    ->visible(function (Conge $record) {
                        /** @var \App\Models\User|null $user */
                        $user = \Illuminate\Support\Facades\Auth::user();
                        return $record->statut === 'en_attente' && $user && $user->hasRole('admin');
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Si l'utilisateur est connecté mais N'EST PAS admin (donc c'est un employé)
        if ($user && !$user->hasRole('admin')) {
            // On filtre pour ne garder que SES propres congés
            $query->whereHas('employe', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConges::route('/'),
            'create' => Pages\CreateConge::route('/create'),
            'edit' => Pages\EditConge::route('/{record}/edit'),
        ];
    }
}