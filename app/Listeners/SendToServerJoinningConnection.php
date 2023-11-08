<?php

namespace App\Listeners;

use App\Events\JoinConnection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendToServerJoinningConnection
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        dd('bddd');
    }

    /**
     * Handle the event.
     */
    public function handle(JoinConnection $event): void
    {
        dd('gondes');
    }
}
