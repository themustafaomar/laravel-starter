<?php

namespace Database\Seeders;

use App\Models\User;
use App\Notifications\WelcomeAboard;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ])
            ->assignRole('super admin')->notify(new WelcomeAboard);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ])
            ->assignRole('admin')->notify(new WelcomeAboard);

        User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
        ])
            ->assignRole('moderator')->notify(new WelcomeAboard);
    }
}
