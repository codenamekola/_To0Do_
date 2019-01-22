<?php

namespace App\Listeners;

use App\Events\TodoEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TodoEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TodoEvent  $event
     * @return void
     */
    public function handle(TodoEvent $event)
    {
        \Session::flash('event','Todo ('.$event->todo.') created successfully!');
    }
}
