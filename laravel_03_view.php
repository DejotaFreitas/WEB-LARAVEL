<!DOCTYPE html>
<html lang="pt" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>VIEW</title>
		<!-- token de autenticação da pagina -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
	</head>
	<body>
		<h1>VIEW</h1>
		<h1>Hello, {{ $nome }} {{ $sobrenome }}</h1>
	</body>
</html>

//=======================Route=========================
<?php


Route::get('/view', function() {
    // return view('minhaview', ['nome'=>'Joao Paulo']);
    // ou
    return view('view')->with('nome','Joao')->with('sobrenome', 'Paulo');

});

Route::get('/view/{nome}/{sobrenome}', function($nome, $sobrenome) {
    return view('view', ['nome'=> $nome, 'sobrenome' => $sobrenome]);
    // ou
    // return view('view', compact('nome', 'sobrenome'));
});

Route::get('/email/{email}', function($email) {
    if (View::exists('email')) {
        return view('email', ['email'=> $email]);
    }
    else
        return view('erro');
});

 ?>
