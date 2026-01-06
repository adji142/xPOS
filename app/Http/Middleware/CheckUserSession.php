<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserSession
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Jika session_id kosong atau tidak cocok → logout
            if (
                empty($user->current_session_id) ||
                $user->current_session_id !== session()->getId()
            ) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect('/')
                    ->withErrors(['message' => 'Session Anda telah berakhir']);
            }
        }

        return $next($request);
    }
}
