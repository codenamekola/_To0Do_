<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Auth;
use App\User;
use App\Todo;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return $this->userView();
    }

    public function localLang($lang = null){

        App::setlocale($lang);

        return $this->userView();
    }

    public function userView(){

        $user = Auth::user();

        $todos = Todo::where('user_id',$user->id)->latest()->get();

        return view('home')->with('todos',$todos);
    }

}
