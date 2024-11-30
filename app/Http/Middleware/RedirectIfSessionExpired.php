<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfSessionExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->session()->has('lastActivityTime')) {
            $sessionTimeout = config('session.lifetime') * 60;
            $lastActivityTime = $request->session()->get('lastActivityTime');
            $currentTime = time();

            if ($currentTime - $lastActivityTime > $sessionTimeout) {
                Auth::logout();
                $request->session()->flush();

                toastr()->error('Session Habis. Silahkan login kembali.');
                return redirect()->route('login')->with('message', 'Session Habis. Silahkan login kembali.');
            }
        }

        $request->session()->put('lastActivityTime', time());
        return $next($request);
    }
}
