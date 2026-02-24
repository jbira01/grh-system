<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DossierEmployeResource\Pages;
use App\Filament\Resources\DossierEmployeResource\RelationManagers;
use App\Models\DossierEmploye;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DossierEmployeResource extends Resource
{
    protected static ?string $model = DossierEmploye::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        return $user && $user->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employe_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('numero')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('statut')
                    ->required()
                    ->maxLength(255)
                    ->default('actif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employe_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('numero')
                    ->searchable(),
                Tables\Columns\TextColumn::make('statut')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDossierEmployes::route('/'),
            'create' => Pages\CreateDossierEmploye::route('/create'),
            'edit' => Pages\EditDossierEmploye::route('/{record}/edit'),
        ];
    }
}
