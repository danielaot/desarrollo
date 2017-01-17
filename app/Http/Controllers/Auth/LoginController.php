<?php

namespace App\Http\Controllers\Auth;

session_start();

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\GDirNacional;
use App\Models\GVendedor;

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
    protected $redirectTo = '/reimprimirfactura';

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

        $user = User::where(['login' => $request->login, 'password' => md5($request->password), 'numactivo' => '1'])
                    ->first();

        $dirnacional = GDirNacional::where('dir_txt_cedula', $user->idTerceroUsuario)
                                   ->first();

        if(count($user) > 0){
          Auth::loginUsingId($request->login);

          $fechaIngreso = time();
          Auth::user()->update(['fechaIngreso' => $fechaIngreso]);

          $vendedor = GVendedor::find($user->idTerceroUsuario);

          $_SESSION['app'] = 'aplicativos';
          $_SESSION['idUsuario'] = $user->login;
          $_SESSION['idTercero'] = $user->idTerceroUsuario;
          $_SESSION['ultimoIngreso'] = $fechaIngreso;
          $_SESSION['cedula'] = $user->idTerceroUsuario;
          $_SESSION['nombreCompleto'] = $user->nombre.' '.$user->apellido;
          $_SESSION['correoElectronico'] = $dirnacional ? $dirnacional->dir_txt_email : '';
          $_SESSION['ven_id'] = $vendedor ?  $vendedor->ven_id : '';

          return redirect(env('APPV1_URL'));
        }

        return response()->json(false);
    }
}
