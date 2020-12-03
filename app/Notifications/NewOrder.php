<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrder extends Notification
{
    use Queueable;


    public $order;
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        //
        $this->order=$order;
       // $this->user=$user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public  function  toDatabase($notifiable){
        return [
            'order'=>$this->order,
         //   'user'=>$this->user
        ];
    }

    public  function  toBroadcast($notifiable){
        return new BroadcastMessage( [
            'order'=>$this->order,
//            'user'=>$this->user
        ]);
//
//        return new BroadcastMessage( [
//            'notification'=> $notifiable->notifications()->latest()->first()
//        ]);
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order'=>$this->order,
        //    'user'=>$this->user
        ];
    }

//    public function broadcastOn()
//    {
//        return new PrivateChannel('newOrder');
//    }
//
//    public function toBroadcast($notifiable)
//    {
//        return new BroadcastMessage([
//            'notification'=> $notifiable->notifications()->latest()->first()
//        ]);
//    }
}
