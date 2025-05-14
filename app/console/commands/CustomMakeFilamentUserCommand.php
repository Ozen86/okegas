<?php

namespace App\Console\Commands;

use Filament\Commands\MakeUserCommand as FilamentMakeUserCommand;
use Illuminate\Support\Facades\Hash;

class CustomMakeFilamentUserCommand extends FilamentMakeUserCommand
{
    protected $signature = 'make:custom-filament-user';
    protected $description = 'Create a Filament user with admin option';

    public function handle(): int
    {
        $name = $this->askRequired('Name', 'name');
        $email = $this->askRequired('Email address', 'email', fn (string $email): bool => filter_var($email, FILTER_VALIDATE_EMAIL) !== false);
        $password = Hash::make($this->askRequired('Password', 'password'));
        
        // Pertanyaan tambahan: apakah user ini Super Admin?
        $isSuperAdmin = $this->confirm('Is Super Admin?', false);

        $user = $this->getUserModel()::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'is_admin' => $isSuperAdmin,
        ]);

        $loginUrl = route('filament.admin.auth.login');
        $this->info("Success! {$user->email} may now log in at {$loginUrl}." . ($isSuperAdmin ? ' User is set as Super Admin.' : ''));

        return static::SUCCESS;
    }
}
