<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class PermissionTableSeeder extends Seeder
{
    private $guardName = 'sanctum';

    /**
     * Run the database seeds.
     */
    public function run(Collection $data): void
    {
        $this->createPermissions($data->first());

        $data->each(function (array $permissions, string $role) {
            $this->assign($role, $permissions);
        });
    }

    /**
     * Assign permissions to each role.
     * 
     * @param string $role
     * @param array $permissions
     * @return void
     */
    private function assign(string $role, array $permissions)
    {
        collect($permissions)->each(function ($value, $key) use ($role) {
            Role::findByName($role, $this->guardName)
                ->givePermissionTo($this->normalizePermissions($value, $key));
        });
    }

    /**
     * Generate all permissions with its own role name.
     * 
     * @param array $permissions
     * @return void
     */
    private function createPermissions(array $permissions)
    {
        $permissions = collect($permissions)
            ->map(fn ($value, string $key) => $this->normalizePermissions(
                $value, $key
            ))
            ->flatMap(fn ($value, $key) => collect($value)->map(fn ($permission) => [
                'name' => $permission,
                'group_name' => $key,
                'guard_name' => $this->guardName,
            ]))
            ->toArray();

        Permission::insert($permissions);
    }

    /**
     * Normalize permissions list.
     * 
     * @param array|string $permissions
     * @param string $key
     * @return array
     */
    private function normalizePermissions(array|string $permissions, string $key): array
    {
        if ($permissions === '*') {
            return ["create $key", "read $key", "update $key", "delete $key"];
        }

        return collect($permissions)
            ->map(fn (string $permission) => "$permission $key")
            ->toArray();
    }
}