<?php

namespace App\Listeners;

use App\Models\Order;
use App\Models\User;
use App\Notifications\NewOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
//    public  $order;
//    public function __construct(Order $order)
//    {
//        $this->order=$order;
//    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        $admin=User::where('userType','Admin')->get();

        Notification::send($admin,new NewOrder($event->order));
    }
}
