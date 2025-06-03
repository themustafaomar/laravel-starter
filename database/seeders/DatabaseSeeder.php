<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $roles = collect(require_once database_path('data/roles.php'));

        $this->callWith([
            RoleTableSeeder::class,
            PermissionTableSeeder::class,
        ], [
            'data' => $roles,
        ]);

        $this->call(UserTableSeeder::class);
    }
}
