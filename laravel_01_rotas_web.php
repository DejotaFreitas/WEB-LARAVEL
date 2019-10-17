<?php

//Path do arquivo de rotas
// projeto/routes/web.php

Route::get('/', function () {
    return view('welcome');
});

//=================================================================
// rota para um controller resource
Route::resource('/cliente', 'ClienteControler');

//=================================================================
// interagindo com as views

Route::get('/ola', function() {
    // return view('minhaview', ['nome'=>'Joao Paulo']);
    // ou
    return view('minhaview')->with('nome','Joao')->with('sobrenome', 'Paulo');

});

Route::get('/ola/{nome}/{sobrenome}', function($nome, $sobrenome) {
    return view('minhaview', ['nome'=> $nome, 'sobrenome' => $sobrenome]);
    // ou
    // return view('minhaview', compact('nome', 'sobrenome'));
});

Route::get('/email/{email}', function($email) {
    if (View::exists('email')) {
        return view('email', ['email'=> $email]);
    }
    else
        return view('erro');
});
//=================================================================

Route::get('/usuario/{nome}/{sobrenome}', function ($nome, $sobrenome) {
    return "<h1>Olá $nome $sobrenome.</h1>";
});

//=================================================================

// Parametros opcionais
Route::get('/seunome/{nome?}', function ($nome=null) {
    if (isset($nome))
        return "<h1>Ola, $nome!</h1>";
    return "<h1>Voce nao digitou nenhum nome.</h1>";
});

//=================================================================

// Regras para Parametros
Route::get('/seunomecomregra/{nome}/{n}', function ($nome, $n) {
    $s = '';
    for ($i=0;$i<$n;$i++)
        $s .= "<h1>Ola, $nome!</h1>";
    echo $s;
})->where('nome', '[A-Za-z]+')->where('n','[0-9]+');

//=================================================================

// Agrupamento de Rotas
Route::prefix('app')->group(function () {
    Route::get('/', function () {
        return 'Meu app';
    });

    Route::get('profile', function () {
        return 'Profile do meu App';
    });
});


//=================================================================

// Redirecionamento de rotas
Route::redirect('/aqui', '/hello', 301);

//=================================================================

// Rotas diretas para Views
Route::view('/minhaview', 'hello');

// na view resources/views/olanome.blade.php esta usando as variaveis  $nome e $sobrenome
// <h1>Olá {{$nome}} {{$sobrenome}} </h1>
Route::view('/olanome', 'hellonome', ['nome'=>'Joao', 'sobrenome'=>'Silva'] );

Route::get('/olanome/{nome}/{sobrenome}', function($nome, $sobrenome){
    return view('hellonome', ['nome'=>$nome, 'sobrenome'=>$sobrenome] );
});

//=================================================================

// Utilizando outros metodos do HTTP
// Editar: app/Http/Middleware/VerifyCsrfToken.php

Route::get('/hellorest', function () {
    return 'Hello World1 (GET)';
});

Route::post('/hellorest', function () {
    return 'Hello World1 (POST)';
});

Route::delete('/hellorest', function () {
    return 'Hello World1 (DELETE)';
});

Route::put('/hellorest', function () {
    return 'Hello World1 (PUT)';
});

Route::patch('/hellorest', function () {
    return 'Hello World1 (PATCH)';
});

Route::options('/hellorest', function () {
    return 'Hello World1 (OPTIONS)';
});

//=================================================================

// use Illuminate\Http\Request;

// Atendendo varios metodos em uma unica regra
Route::match(['get', 'post'], '/hello2', function () {
    return 'Hello World 2';
});

// recebe todos os metodos http e uma unica rota
Route::any('/qualquer', function () {
    return 'Hello World 3';
});


//=================================================================


// Nomeando Rotas
Route::get('/produtos', function () {
    echo "<h1>Produtos</h1>";
    echo "<ol>";
    echo "<li>Notebook </li>";
    echo "<li>Impressora </li>";
    echo "<li>Mouse </li>";
    echo "</ol>";
})->name('meusprodutos');

// Usando Rota Nomeada
Route::get('/linkprodutos', function () {
    $url = route('meusprodutos');
    echo "<a href=\"" . $url . "\">Meus Produtos</a>";
});
// Redirecionando para routa nomeada
Route::get('/redirecionarprodutos', function () {
    return redirect()->route('meusprodutos');
});
