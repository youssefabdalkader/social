<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms;
use Filament\Forms\Form;
use Spatie\Permission\Models\Role;


use function Laravel\Prompts\select;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form->schema([
            ...parent::form($form)->getComponents(), // 👈 المهم


            Forms\Components\FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('users'),


            Forms\Components\Select::make('role')
                ->options(
                    Role::where('name', '!=', 'admin')->Where('name', '!=', 'User')
                        ->pluck('name', 'name')
                        ->toArray()
                )
                ->default('user')
                ->required(),
        ]);
    }

    protected function handleRegistration(array $data): \Illuminate\Database\Eloquent\Model
    {
        $user = parent::handleRegistration($data);

        $user->update([
            'image' => $data['image'] ?? null,


        ]);

        $user->assignRole($data['role']);


        return $user;
    }
}
