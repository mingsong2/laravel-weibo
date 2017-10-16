<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Policies\StatusPolicy;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
class StaticPagesController extends Controller
{
    public function home(){

        $feed_items = [];

        $user = User::first();

        if(Auth::check()){
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        return view('static_pages/home',compact('feed_items'));
    }
    public function help(){
        return view('static_pages/help');
    }
    public function about(){
        return view('static_pages/about');
    }
}
