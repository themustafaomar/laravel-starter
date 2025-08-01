<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    /**
     * Determine whether the user can mark a notification as read.
     */
    public function markAsRead(User $user, DatabaseNotification $notification): bool
    {
        return $notification->notifiable->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DatabaseNotification $notification): bool
    {
        return $notification->notifiable->is($user);
    }
}
