<?php

namespace App\Http\Controllers\Api\AccessControl;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Requests\AccessControl\RoleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(Request $request)
    {
        return RoleResource::collection(
            Role::with('permissions')->latest()->get()
        );
    }

    /**
     * Display the specified resource.
     * 
     * @param \App\Models\Role $role
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
     * @param \App\Http\Requests\AccessControl\RoleRequest $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->syncPermissions($request->permissions);

        return response()->noContent();
    }
}
