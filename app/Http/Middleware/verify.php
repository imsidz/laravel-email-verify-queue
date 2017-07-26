<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Mail;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\SendVerificationEmail;


class Verify
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
         if (!Auth::guest() && Auth::user()->verified) {
            
            return $next($request);
        }
        else{
            $user = Auth::user();

            dispatch(new SendVerificationEmail($user));

            Auth::logout();
            return Redirect::back()->with('warning', 'You Are Not Verified We sent again verify email please check your email sometime if you didnt get email please check spam mail');
        }
        
    }
}