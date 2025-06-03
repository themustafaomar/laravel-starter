<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(Request $request)
    {
        return NotificationResource::collection(
            $request->user()->notifications()->take(15)->latest()->paginate()
        );
    }

    /**
     * Mark a given notification as read
     * 
     * @param \Illuminate\Notifications\DatabaseNotification
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param \Illuminate\Notifications\DatabaseNotification $notification
     * @param \Illuminate\Http\Response
     */
    public function destroy(DatabaseNotification $notification)
    {
        // @TODO: Authorize this

        $notification->delete();

        return response()->noContent();
    }
}