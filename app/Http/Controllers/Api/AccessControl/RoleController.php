<?php

namespace App\Http\Controllers\Api\AccessControl;

use App\Http\Requests\AccessControl\AssignRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(Request $request)
    {
        return RoleResource::collection(
            Role::with('permissions')->latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->validated());

        if ($request->filled('permissions')) {
            $role->permissions()->attach($request->permissions);
        }

        return response()->ok();
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Http\Resources\RoleResource
     */
    public function show(Role $role)
    {
        return new RoleResource(
            $role->load('permissions')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        // We won't update the role name, cause we rely on this name
        // internally for permission checks, so we only update permissions.
        // If you need to update the role name, you can modify this logic accordingly.

        $role->syncPermissions($request->permissions);

        return response()->ok();
    }

    /**
     * Assign roles to a given user.
     * 
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function assignRoles(AssignRoleRequest $request, User $user)
    {
        if ($user->hasRole('super admin')) {
            throw new AuthorizationException('Cannot assign roles to a super admin.');
        }

        $this->authorize('assignRoles', Role::class);

        $user->syncRoles($request->roles);

        return response()->ok();
    }
}
