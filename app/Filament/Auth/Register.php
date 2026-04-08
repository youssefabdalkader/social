<?php
namespace App\Filament\Auth;

use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms;
use Filament\Forms\Form;

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
        ]);
    }

    protected function handleRegistration(array $data): \Illuminate\Database\Eloquent\Model
    {
        $user = parent::handleRegistration($data);

        $user->update([
            'image' => $data['image'] ?? null,
        ]);


        return $user;
    }
}
