<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function danhSachUsers(){
        $users = User::get();
        return view('user.danh-sach-user')->with([
            'users'=>$users
        ]);
    }
    public function addUSer(Request $req){

        // Validate
        $data = [
            'name'=>$req->name,
            'image'=>$req->image,
            'email'=>$req->email,
            'password'=>Hash::make('password')
        ];
        $user =  User::create($data);
        broadcast(new UserCreated($user));
    }
}
