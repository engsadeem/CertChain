<?php

namespace App\Models;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class RoleRequestNotification extends Notification
{
    public function __construct(public int $userId, public string $userName, public string $email) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'role_request',
            'title' => 'New verifier request',
            'body'  => $this->userName . ' — ' . $this->email,
            'user_id' => $this->userId,
        ];
    }
}

