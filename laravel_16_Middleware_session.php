<?php
//==================ROUTE===================================================
use Illuminate\Http\Request;
use App\Http\Middleware\UsuarioMiddleware;

Route::get('/', 'UsuarioControle@index')
->middleware(UsuarioMiddleware::class);

Route::get('/negado', function () {
  return "Acesso negado. Somente usuarios logados podem acessar os produtos.";
});

Route::get('/restrito', function () {
  return "Acesso negado. Somente administrador tem acesso aos produtos";
});

Route::get('/login/{login}/{senha}', function (Request $request, $login, $senha) {
    if( $login === 'dejota' && $senha === "0123") {
      $login = [ 'user' => $login, 'isadmin' => false ];
      $request->session()->put('login', $login);
      return redirect('/');
    } elseif ( $login === 'admin' && $senha === "admin") {
      $login = [ 'user' => $login, 'isadmin' => true ];
      $request->session()->put('login', $login);
      return redirect('/');
    } else {
      $request->session()->flush();
      return redirect('/');
    }
});

Route::get('/logout', function (Request $request) {
    $request->session()->flush();
    return redirect('/');
});


//=========================Middleware============================================

class UsuarioMiddleware {

    public function handle($request, Closure $next) {
      if ($request->session()->exists('login')) {
            $login = session('login');
            $isadmin = $login['isadmin'];
            if ($isadmin)
                return $next($request);
            else {
              return redirect('/restrito');
            }
        }
        return redirect('/negado');
    }

}

//===================Controller==================================================
// forma de adicionar middleware ao todas chamdas desse controle

// use App\Http\Middleware\UsuarioMiddleware;
class UsuarioControle extends Controller{
	// public function __construct() {
  //   $this->middleware(\App\Http\Middleware\ProdutoAdmin::class);
  // }
  function index(Request $request)  {
		return json_encode(session('login'));
  }

}
//=====================================================================
