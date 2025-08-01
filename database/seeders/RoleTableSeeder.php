<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Collection $data): void
    {
        $roles = $data->keys()->map(fn ($role) => [
            'name' => $role,
            'guard_name' => 'sanctum',
        ])->toArray();

        Role::insert($roles);
    }
}
