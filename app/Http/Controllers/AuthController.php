<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    function login(){
        return view('admin.auth.login');
    }

    function register(Request $req){
        if($req->isMethod('post')){
            $post_data=$req->all();
            $validator=Validator::make($post_data,[
                'name'=>"required|alpha_dash|min:3",
                'email'=>"required|email",
                'phone'=>"required|numeric|min:3",
                'password'=>"required|string|min:3|confirmed",
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user=User::where('email',$req->email)->where('phone',$req->phone)->first();

            dd($user);

        }
        return view('admin.auth.register');
    }
}
