<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        switch ($role) {
            case 'student':
                if (!$user->isStudent()) {
                    abort(403, 'Unauthorized');
                }
                break;
            case 'counselor':
                if (!$user->isCounselor()) {
                    abort(403, 'Unauthorized');
                }
                break;
            case 'admin':
                if (!$user->isAdmin()) {
                    abort(403, 'Unauthorized');
                }
                break;
        }

        return $next($request);
    }
}
