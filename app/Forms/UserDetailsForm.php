<?php

namespace App\Forms;

use App\Models\User;
use Filament\Forms\Components\TextInput;

class UserDetailsForm
{
    public static function schema(User $user): array
    {
        return [
            TextInput::make('last_name')
                ->label('Nom')
                ->required()
                ->rules('required|string')
                ->default($user->last_name),
            TextInput::make('first_name')
                ->label('Prénom')
                ->required()
                ->rules('required|string')
                ->default($user->first_name),
            TextInput::make('phone')
                ->label('Numéro de téléphone')
                ->required()
                ->rules([
                    'required',
                    'regex:/^0[1-9]\d{8}$/',
                    'unique:users,phone,' . $user->id,
                ])
                ->default($user->phone)
                ->maxLength(10),
            TextInput::make('email')
                ->label('Adresse e-mail')
                ->required()
                ->rules('sometimes|required|email|unique:users,email,' . $user->id)
                ->default($user->email),
        ];
    }
}

