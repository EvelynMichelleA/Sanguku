<?php

// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Jika pengguna tidak memiliki salah satu role yang diizinkan, tolak akses
        if ($user && in_array($user->role->nama_role, $roles)) {
            return $next($request);
        }

        // Redirect atau kembalikan respons jika akses ditolak
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
