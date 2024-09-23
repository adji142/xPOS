<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DetectClientOS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userAgent = $request->header('User-Agent');
        $os = $this->detectOS($userAgent);

        // Attach the detected OS to the request
        $request->merge(['client_os' => $os]);

        return $next($request);
    }

    /**
     * Detect the operating system from the User-Agent string.
     *
     * @param  string  $userAgent
     * @return string
     */
    private function detectOS($userAgent)
    {
        $osArray = [
            'Windows' => 'Windows',
            'Macintosh' => 'Mac OS',
            'Linux' => 'Linux',
            'iPhone' => 'iOS',
            'iPad' => 'iOS',
            'Android' => 'Android',
        ];

        foreach ($osArray as $key => $os) {
            if (stripos($userAgent, $key) !== false) {
                return $os;
            }
        }

        return 'Unknown OS';
    }
}
