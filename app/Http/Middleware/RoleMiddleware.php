<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) { // Jika belum login, redirect ke login
            return redirect('login');
        }

        $user = Auth::user();
        if (!in_array($user->role, $roles)) {
            // Jika role tidak sesuai, bisa redirect ke halaman unauthorized atau home
            // Atau, redirect ke dashboard masing-masing role jika salah masuk
            if ($user->isAdmin()) return redirect()->route('admin.dashboard');
            if ($user->isKaryawan()) return redirect()->route('karyawan.dashboard');
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        return $next($request);
    }
    
}
class IsAdmin
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
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }
}