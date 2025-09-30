<?php

use App\Models\GroupChat;
use App\Events\GroupChatEvent;
use App\Models\GroupChatDetail;
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
Broadcast::channel('thongBao', function ($user, $type) {
    return $user != null;
});
Broadcast::channel('nguoiOnline', function ($user) {
    if($user!=null){
        return ['id'=>$user->id,'name'=>$user->name];
    }else{
        return false;
    }
});
Broadcast::channel('users', function ($user) {
   return $user != null;
});

Broadcast::channel('chatPrivate.{idNguoiGui}.{idNguoiNhan}', function ($user,$idNguoiGui,$idNguoiNhan) {
   if($user != null){
        if($user->id == $idNguoiGui || $user->id == $idNguoiNhan){
            return true;
        }
   }
   return false;
});
Broadcast::channel('chatGroup.{groupId}', function ($user,$groupId) {
   if($user != null ){
       $group = GroupChat::find($groupId);
       $member_id = GroupChatDetail::where('groupchat_id',$groupId)->pluck('member_id')->toArray();
       if($user->id == $group->leader || in_array($user->id,$member_id)){
            return true;
       }
   }
   return false;
});

