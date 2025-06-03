<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * 
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->user()->load(['roles', 'permissions']);

        return (new UserResource($user = $request->user()))
            ->additional([
                'meta' => [
                    'token' => $user->createToken($user->name)->plainTextToken,
                ],
            ]);
    }

    /**
     * Destroy an authenticated session.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
