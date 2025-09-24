<?php

namespace App\Http\Controllers;

use App\Events\ChatRieng;
use App\Events\UserOnline;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatPublic(){
        $users = User::where("id","<>",Auth::user()->id)->get();
        return view('Chat.index')->with([
            'users'=>$users
        ]);
    }
    public function nhanTin(Request $req){
                broadcast(new UserOnline($req->user(),$req->message));
                return response()->json('message broadcase');

    }
    public function chatPrivate($userId){
            echo $userId;
            $user = User::find($userId);
            return view('Chat.chatRieng')->with([
                'user' => $user
            ]);
    }
    public function nhanTinRieng($userId, Request $req){
         broadcast(new ChatRieng($req->user(), User::find($userId), $req->message));
        return response()->json('message broadcase');

    }
}
