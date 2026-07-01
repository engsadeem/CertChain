<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RoleRequestNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $requestId,
        public int $userId,
        public string $userName,
        public string $email
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'role_request',
            'title' => 'New verifier request',
            'body' => $this->userName . ' - ' . $this->email,
            'request_id' => $this->requestId,
            'user_id' => $this->userId,
        ];
    }
}
