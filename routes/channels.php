<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
//
//
//Broadcast::channel('chatroom', function ($user) {
//    return $user;
//});
//
//Broadcast::channel('newOrder',function ($order){
////   if(\Illuminate\Support\Facades\Auth::user()->userType!='User'){
////       return $order->toArray();
////   }
//
//    return $order;
//});
