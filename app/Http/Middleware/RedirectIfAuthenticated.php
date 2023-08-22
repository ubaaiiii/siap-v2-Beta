<?php
namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use guard;
use DB;
use Session;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // $password = md5($request->password);
        // dd(DB::select("SELECT * FROM ms_admin WHERE username='$request->username' AND password='$password'"));
        // if (DB::select("SELECT * FROM ms_admin WHERE username='$request->username' AND password='$password'")) {
        //     dd("sini");
        //     return redirect('/index');
        // }
        // dd($password);
        // Session::flush();
        // dd(Session::get('login'));
        // if (Session::get('login')) {
        //     return redirect('/index');
        // }
        // if ($guard == "writer" && Auth::guard($guard)->check()) {
        //     return redirect('/writer');
        // }
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/home');
        // }
            // dd(Auth::guard($guard));

        return $next($request);
        // $guards = empty($guards) ? [null] : $guards;
        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //         return redirect(RouteServiceProvider::HOME);
        //     }
        // }
        // return $next($request);
    }
}
