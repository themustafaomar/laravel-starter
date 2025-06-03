<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Profile\AvatarRequest;
use App\Http\Requests\Profile\UpdateRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Profile\UpdatePasswordRequest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param \App\Http\Requests\Profile\UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UpdateRequest $request)
    {
        $request->user()->update($request->validated());

        return response()->noContent();
    }

    /**
     * Get the current user.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update the user's profile picture.
     * 
     * @param \App\Http\Requests\Profile\AvatarRequest $request
     * @return \Illuminate\Http\Response
     */
    public function changeAvatar(AvatarRequest $request)
    {
        $url = $request->user()->addMediaFromRequest('avatar')
            ->withCustomProperties([
                'coords' => explode(',', $request->coords),
            ])
            ->toMediaCollection('avatar', 'public')
            ->getFullUrl('thumb');

        return response()->json([
            'avatar' => $url,
        ]);
    }

    /**
     * Update the user's password.
     * 
     * @param \App\Http\Requests\Profile\UpdatePasswordRequest
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        if (! Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'The old password is wrong',
            ]);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->noContent();
    }
}