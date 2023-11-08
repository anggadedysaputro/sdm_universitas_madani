<?php

namespace App\Traits\Logger;

use App\Models\Logs\Activity;

trait TraitsLoggerActivity
{
    public function activity($subject = "", $error = "")
    {
        // dd(session()->all());
        $clientIP = request()->ip();
        $currentUrl = url()->full();
        $userId = session('id');
        $userAgent = request()->useragent();
        $method = request()->method();

        $createLogActivity = [
            'ip' => $clientIP,
            'url' => $currentUrl,
            'user_id' => $userId,
            'subject' => $subject,
            'user_agent' => $userAgent,
            'method' => $method,
            'error' => $error
        ];

        Activity::create($createLogActivity);
    }
}
