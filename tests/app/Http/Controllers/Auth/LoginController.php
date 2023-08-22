<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Admin as AdminModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Str;
use App\Mail\SendResetPassword;
use function PHPSTORM_META\map;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterRequest;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\User as Authenticatable; 



class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:user')->except('logout');
    }

    public function logout()
    {
        // if (Auth::guard('admin')->check()) {
        //     Auth::guard('admin')->logout();
        //     return redirect('/');
        // }
        // if (Auth::guard('user')->check()) {
        //     Auth::guard('user')->logout();
        //     return redirect('login/user');
        // }
        // Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);
        // Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password]);
        $password = md5($request->password);
        // dd($password);
        if ($data = DB::select("SELECT * FROM ms_admin WHERE username='$request->username' AND password='$password'")) {
            // Auth::guard('admin')->login($data[0]);
            // dd($data);
            Session::put('login',$data);
            // dd(Session::get('login'));
            return redirect()->intended('/index');
            // code...
        }
        // if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
        // }

        // dd(AdminModel::get());
        // return back()->withInput($request->only('email', 'remember'));
        return redirect('/login')->with(['error' => 'Data tidak ditemukan silahkan hibungi admin !']);
    }

    public function showUsersLoginForm()
    {
        return view('auth.login', ['url' => 'user']);
    }

    public function userLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);


        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/user');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            // echo "Masuk";
            $user = Socialite::driver('google')->user();
            $findUser = DB::table('chc_member')
                ->where('google_id', $user->id)->first();
            // dd($findUser);
            if(!$findUser){
                // session()->flash('error', 'Data tidak ditemukan silahkan hibungi admin !');
                return redirect('/login')->with(['error' => 'Data tidak ditemukan silahkan hibungi admin !']);
            }else{
                $params['id_user'] = $findUser->id_member;
                $params['username'] = $findUser->username;
                // $params['category'] = 'client';
                $params['status'] = 'sukses';
                // SysLog::insertLog($params);
                Auth::guard('admin')->loginUsingId($findUser->id_member);
                // if (!$findUser->address_client) {
                //     session()->flash('nothing', 'silahkan lengkapi profil Anda dahulu !');
                // }
            }    

            return redirect()->intended('index')->with('success', 'Anda telah login menggunakaan akun gmail');
            
        } catch (\Throwable $th) {
            // echo "Kesini";
            return response()->json( [
                'status' => false,
                'message' =>$th->getMessage()
            ]);
        }
    }

    



}
