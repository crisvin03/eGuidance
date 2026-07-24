<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * After login, block users who are not yet approved (is_active = false).
     * Counselors, admins, and students are always allowed through.
     */
    protected function authenticated(Request $request, $user)
    {
        // Counselors and admins are never blocked
        if ($user->isCounselor() || $user->isAdmin()) {
            return redirect()->intended($this->redirectPath());
        }

        // Block inactive (unapproved) teachers/students
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->with('approval_pending', true)
                ->withInput(['email' => $user->email]);
        }

        return redirect()->intended($this->redirectPath());
    }
}
