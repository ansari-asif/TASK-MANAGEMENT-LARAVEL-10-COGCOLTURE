<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function login(Request $req){
        if($req->isMethod('post')){
            $post_data=$req->all();
            $validator=Validator::make($post_data,[
                "email"=>"required|email",
                "password"=>"required|min:3",
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user=Auth::attempt([
                "email"=>$req->email,
                "password"=>$req->password,
                "status"=>1
            ]);
            if($user){
                return redirect('/')->with(['success'=>"Registration Successfully Completed."]);
            }else{
                return redirect()->back()->with(['error'=>"Invalid Email or password."]);
            }
        }
        return view('admin.auth.login');
    }

    function register(Request $req){
        if($req->isMethod('post')){
            $post_data=$req->all();
            $validator=Validator::make($post_data,[
                'name'=>"required|string|min:3",
                'email'=>"required|email",
                'phone'=>"required|numeric|min:10",
                'password'=>"required|string|min:3|confirmed",
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user=User::where('email',$req->email)->orWhere('phone',$req->phone)->first();
            if($user){
                return redirect()->back()->with(['error'=>"Email or Phone already exists."]);
            }else{
                $post_data=[
                    "name"=>$req->name,
                    "email"=>$req->email,
                    "phone"=>$req->phone,
                    "password"=>Hash::make($req->password),
                    "status"=>1,
                    "user_type"=>"normal",
                ];
                $user=User::create($post_data);
                Auth::login($user);
                return redirect('/')->with(['success'=>"Registration Successfully Completed."]);
            }
        }
        return view('admin.auth.register');
    }

    function logout(){
        Auth::logout();
        return redirect()->route('login')->with(['success'=>"You are successfully logout."]);
    }
}
