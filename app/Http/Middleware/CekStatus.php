<?php
namespace App\Http\Middleware;
use Closure;
class CekStatus
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
        $user = \App\Models\Admin::where('username', $request->username)->first();
        if ($user->status == 'broker') {
            return redirect('admin/dashboard');
        } elseif ($user->status == 'checker') {
            return redirect('mahasiswa/dashboard');
        } else {
            return dd($user);
        }
        
        return $next($request);
    }
}