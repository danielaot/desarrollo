<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Models\Aplicativos\User;
use App\Models\Aplicativos\LogUsuario;
use App\Models\Genericas\TDirNacional;
use App\Models\Genericas\TVendedor;

use Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Override the username method used to validate login
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Override a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $user = User::where([['login', 'LIKE BINARY', $request->login], 'password' => md5($request->password), 'numactivo' => '1'])
                    ->first();
        if(count($user) > 0){
          $dirnacional = TDirNacional::where('dir_txt_cedula', $user->idTerceroUsuario)
                                     ->first();

          Auth::loginUsingId($request->login,false);

          $time = time();
          Auth::user()->update(['fechaIngreso' => $time]);

          $vendedor = TVendedor::where('ven_id', $user->idTerceroUsuario)
                               ->first();

          $info = [
                    'url' => env('APPV1_URL'),
                    'app' => 'aplicativos',
                    'idUsuario' => $user->login,
                    'idTercero' => $user->idTerceroUsuario,
                    'ultimoIngreso' => $time,
                    'cedula' => $user->idTerceroUsuario,
                    'nombreCompleto' => $user->nombre.' '.$user->apellido,
                    'correoElectronico' => $dirnacional ? $dirnacional->dir_txt_email : '',
                    'ven_id' => $vendedor ?  $vendedor->ven_id : ''
                  ];

          $log = new LogUsuario;
          $log->usu_id = $user->login;
          $log->log_num_creacion = $time;
          $log->log_txt_ip = $_SERVER['REMOTE_ADDR'];
          $log->log_txt_url = $_SERVER['REQUEST_URI'];
          $log->log_num_tipo = 1;

          $log->save();

          return view('session')->with(['inputs' => $info]);
        }

        $errors = ['login' => 'Usuario o Contrase&ntilde;a son incorrectos, vuelva a intentarlo'];

        return redirect()->back()
                         ->withErrors($errors);
    }

    /**
     * Override Log the user out of the application.
     *
     * @return void
     */
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
