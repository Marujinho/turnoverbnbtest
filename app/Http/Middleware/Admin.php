<?php

namespace App\Http\Middleware;
use Auth;
use Domain\User\UserRepository;

use Closure;

class Admin
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $loggedUser = Auth::user();
        $user_bank = $this->user->getUserBank($loggedUser);

        if($user_bank->pivot->role != 'admin') {
            abort(403);
        }

        return $next($request);
    }
}
