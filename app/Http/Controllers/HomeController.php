<?php

namespace App\Http\Controllers;

use App\Models\GroupChat;
use App\Models\GroupChatDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where("id","<>",Auth::user()->id)->get();
    
        return view('home')->with([
            'users'=>$users
        ]);
    }
    public function createGroupChat(Request $req)
    {
        $data = [
            'name' =>$req->tenNhom,
            'leader'=>Auth::user()->id
        ];
        $groupChat = GroupChat::create($data);
        foreach($req->member as $menber){
            $data2 = [
                'groupchat_id'=>$groupChat->id,
                'member_id'=>$menber
            ];
            GroupChatDetail::create($data2);
        }
    }
}
