<?php

namespace App\Http\Controllers;

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

    }
}
