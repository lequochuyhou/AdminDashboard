<?php

namespace App\Events;

use App\Models\Order;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $order;
  //  public  $user;
    public function __construct($order)
    {
        //
        $this->order=$order;
//        $this->user=$user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */

    //Channel
    public function broadcastOn()
    {
        return ['new-order'];
    }


    //Event
    public  function broadcastAs(){
        return 'get-order';
    }
//    public function broadcastWith()
//    {
//        return [
//            'order' => $this->order,
////            'user' => $this->order,
//        ];
//    }
}
