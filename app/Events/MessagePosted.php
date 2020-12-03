<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessagePosted implements  ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public  $id;
    public  $user;
    public $for_user_id;
    /**
     * Create a new event instance.
     * @param string $message (notification description)
     * @param integer $id (notification id)
    * @param object $user (notification id)
     * @param integer $for_user_id (receiver's id)
     * @author hkaur5
     * @return void
     */
    public function __construct($message,$for_user_id,$user)
    {
        //
        $this->message=$message;
    //    $this->id=$id;
        $this->user=$user;
        $this->for_user_id=$for_user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    //Channel
    public function broadcastOn()
    {
        return ['new-message'.$this->for_user_id];
    }


    //Event
    public  function broadcastAs(){
        return 'get-message';
    }
}
