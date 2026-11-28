<?php

namespace App\Services;

use App\Mail\AdminActivityMail;
use Illuminate\Support\Facades\Mail;

class AdminEmailNotificationService
{
    /**
     * @param  array<string, string>  $details
     */
    public function notifyAdministrators(string $headline, array $details, ?string $actionUrl = null): void
    {
        $recipients = config('mail.admin_notification_recipients', []);

        if ($recipients === []) {
            return;
        }

        Mail::to($recipients)->queue(new AdminActivityMail($headline, $details, $actionUrl));
    }
}
