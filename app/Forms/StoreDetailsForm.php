<?php

namespace App\Forms;

use App\Models\Activity;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class StoreDetailsForm
{
    public static function schema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nom du magasin')
                ->required()
                ->maxLength(255),
            TextInput::make('siret')
                ->label('SIRET')
                ->required()
                ->minLength(14)
                ->maxLength(14)
                ->rule('regex:/^\d{14}$/')
                ->helperText('14 chiffres'),
            TextInput::make('customs_code')
                ->label('Code douane')
                ->required()
                ->maxLength(20),
            FileUpload::make('document')
                ->label('Justificatif KBIS')
                ->required()
                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                ->maxSize(4096)
                ->helperText('PDF, JPG ou PNG, max 4 Mo'),
            Select::make('activities')
                ->label('Activités')
                ->multiple()
                ->required()
                ->options(Activity::pluck('name', 'id')->toArray())
                ->helperText('Sélectionnez au moins une activité'),
        ];
    }
}

