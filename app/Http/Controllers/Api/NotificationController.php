<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NotificationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(Request $request)
    {
        return NotificationResource::collection(
            $request->user()->notifications()->latest()->paginate()
        );
    }

    /**
     * Mark a given notification as read
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        $this->authorize('markAsRead', $notification);

        $notification->markAsRead();

        return response()->ok();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Response
     */
    public function destroy(DatabaseNotification $notification)
    {
        $this->authorize('delete', $notification);

        $notification->delete();

        return response()->ok();
    }
}
