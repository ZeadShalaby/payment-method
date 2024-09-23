<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\testEvent;
use App\Traits\ResponseTrait;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;

class testListener
{
    use ResponseTrait;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(testEvent $event): void
    {
        try {
            $event->user->name = "ziad";
            $event->user->save();
        } catch (\Exception $e) {
            return $this->returnError('E001', $e->getMessage());

        }
    }
}
