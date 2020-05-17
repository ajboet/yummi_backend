<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class GuestUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = Route::getRoutes()->match($request);
        $current_route = $route->getName();
        
        if ($current_route == 'index.product' && !auth('sanctum')->user()) {
            // Save guest User
            $rand = Str::random(10);
            $email = 'guest_'.$rand.'@mail.com';
            $user = new User();
            $user->name = 'Guest '.$rand;
            $user->email = $email;
            $user->email_verified_at = now();
            $user->password = bcrypt($email);
            $user->remember_token = $rand;
            $user->full_address = '...';
            $user->cellphone_number = mt_rand();
            $user->save();

            // Attach the token in the request header
            $token = $user->createToken($user->name)->plainTextToken;
            $request->headers->set('guest_user_token', $token);
        }
        return $next($request);
    }
}
