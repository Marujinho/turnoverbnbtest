<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Domain\User\UserRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $user_bank = $this->user->getUserBank($user);
        $user_data = $this->user->prepareUserData($user_bank);

        return view('home', [
          'user_data' => $user_data
        ]);
    }
}
