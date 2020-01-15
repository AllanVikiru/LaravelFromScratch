<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     * for a user to access the dashboard, they have to be authenticated otherwise, BLOCKEDT
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
        $user_id = auth()->user('id')->id;
        $user = User::find($user_id);
        return view('dashboard')->with('posts', $user->posts);
    }
}
