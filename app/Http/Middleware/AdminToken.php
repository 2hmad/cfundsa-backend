<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminToken
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
        $token = $request->header('Authorization');
        if ($token) {
            // $user = Users::where('token', $token)->first();
            // if ($user) {
            //     return $next($request);
            // }
        }
        return response()->json([
            'message' => 'Unauthorized',
        ], 401);
    }
}
