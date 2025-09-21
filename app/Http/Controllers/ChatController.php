<?php

namespace App\Http\Controllers;

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
}
