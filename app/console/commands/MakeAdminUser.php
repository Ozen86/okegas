<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeAdminUser extends Command
{
    /**
     * Nama dan signature dari perintah Artisan.
     *
     * @var string
     */
    protected $signature = 'app:make-admin-user';

    /**
     * Deskripsi dari perintah ini.
     *
     * @var string
     */
    protected $description = 'Membuat user dengan hak akses admin';

    /**
     * Eksekusi perintah.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Masukkan nama user admin');
        $email = $this->ask('Masukkan email user admin');
        $password = $this->secret('Masukkan password user admin');

        // Cek apakah email sudah ada
        if (User::where('email', $email)->exists()) {
            $this->error("User dengan email {$email} sudah ada.");
            return Command::FAILURE;
        }

        // Buat user admin
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
        ]);

        $this->info("User admin berhasil dibuat dengan email: {$user->email}");
        return Command::SUCCESS;
    }
}
