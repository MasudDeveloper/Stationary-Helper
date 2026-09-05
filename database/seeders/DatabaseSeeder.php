<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'credits' => 1000,
            ]
        );

        // Seed default normal user
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'General User',
                'password' => bcrypt('user123'),
                'role' => 'public',
                'credits' => 100,
            ]
        );

        $this->call([
            CvTemplateSeeder::class,
            GrammarSolverSeeder::class,
        ]);
    }
}
