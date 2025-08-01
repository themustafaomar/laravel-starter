<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\AvatarRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UpdateRequest $request)
    {
        $request->user()->update($request->validated());

        return response()->ok();
    }

    /**
     * Get the current user.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update the user's profile picture.
     *
     * @return \Illuminate\Http\JsonResponse
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

        return response()->ok();
    }
}
