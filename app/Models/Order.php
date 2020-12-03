<?php

namespace App\Models;

use App\Notifications\NewOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory,Notifiable;

    protected $fillable=['id','products','totalPrice','user_id'];




    public function sendNewOrderNotification($order){
        $this->notify(new NewOrder($order));
    }


}
