<?php

namespace App\Http\Controllers\Api\AccessControl;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
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
        $this->authorize('viewAny', Role::class);

        return RoleResource::collection(
            Role::with('permissions')->latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \App\Http\Requests\RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->validated());

        if ($request->filled('permissions')) {
            $role->permissions()->attach($request->permissions);
        }

        return response()->noContent();
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
     * @param \App\Http\Requests\RoleRequest $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->syncPermissions($request->permissions);

        return response()->noContent();
    }
}