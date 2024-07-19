<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use \Nwidart\Modules\Facades\Module;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function authenticated(Request $request, $user)
    {
        // dd(auth()->user()->table_name);

        // get table name
        $table_name = auth()->user()->table_name;

        // dd($table_name);
        // set seesion table name in user model
        $_SESSION['table_name'] = $table_name;
    }

    public function logout(Request $request)
    {
        // Hapus session yang tidak perlu dihapus
        $request->session()->forget('_token');

        // rem,ove sesion table)name
        // $_SESSION['table_name'] = '';

        // Jika session device_id ada, simpan nilainya untuk digunakan kembali setelah logout
        $device_id = $request->session()->get('device_id');

        // Lanjutkan proses logout seperti biasa
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Jika session device_id ada, setel kembali session device_id setelah proses logout selesai
        if ($device_id) {
            $request->session()->put('device_id', $device_id);
        }

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(\Illuminate\Http\Request $request)
    {
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'statut' => 1];
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $allModules = Module::all();
        $allEnabledModules = Module::allEnabled();

        $ModulesInstalled = [];
        $ModulesEnabled = [];

        foreach ($allModules as $key => $modules_name) {
            $ModulesInstalled[] = $key;
        }

        foreach ($allEnabledModules as $key => $modules_name) {
            $ModulesEnabled[] = $key;
        }

        return view('auth.login', [
            'ModulesInstalled' => $ModulesInstalled,
            'ModulesEnabled' => $ModulesEnabled,
        ]);
    }
}