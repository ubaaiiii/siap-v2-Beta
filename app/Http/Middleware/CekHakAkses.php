<?php
namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
class CekHakAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $tes)
    {
        // dd(Session::get('login')[0]);
        // $menu = explode(",", $menu[0]->listmenu);
        if(Session::get('login')){
            return $next($request);
        }else{
            return redirect()->intended('/login');
        }
        // if (in_array($tes, $menu)){
        //     return $next($request);
        // }elseif($tes == "all"){
        //     return $next($request);
        // }else{
        //     return redirect()->intended('/index');
        // }
    }
}
