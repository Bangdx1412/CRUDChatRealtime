<?php

namespace App\Http\Controllers;

use App\Events\GroupChatEvent;
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
        $myGroup = GroupChat::where('leader',Auth::user()->id)->get();
        $myGroupNotLeader = GroupChat::leftJoin("groupchat_detail","groupchat.id","=","groupchat_detail.groupchat_id")
        ->select('groupchat.id as groupchatID','groupchat.name')
        ->where("groupchat_detail.member_id","=",Auth::user()->id)->get();
        return view('home')->with([
            'users'=>$users,
            'myGroup'=>$myGroup,
             'myGroupNotLeader'=>$myGroupNotLeader
        ]);
    }
    public function createGroupChat(Request $req)
    {
        $data = [
            'name' =>$req->tenNhom,
            'leader'=>Auth::user()->id,
           
        ];
        $groupChat = GroupChat::create($data);
        foreach($req->member as $menber){
            $data2 = [
                'groupchat_id'=>$groupChat->id,
                'member_id'=>$menber
            ];
            GroupChatDetail::create($data2);
        }
        return redirect()->back();
    }
    public function chatGroup($groupChatId){
        $group = GroupChat::find($groupChatId);
        $leader = User::find($group->leader);
        $member_id = GroupChatDetail::where("groupchat_id",$groupChatId)->pluck('member_id')->toArray();
        $member = User::whereIn("id",$member_id)->get();

        return view('Chat.chatNhom')->with([
            'group'=> $group,
            'leader'=> $leader,
            'member_id'=> $member_id,
            'member'=> $member,
        ]);
    }
    public function nhanTinNhom(Request $req){
         broadcast(new GroupChatEvent(GroupChat::find($req->groupId),$req->user(), $req->message));
        return response()->json('errors');
    }
}
