<?php

Route::get('/categoriaproduto/inserir/{nome}', function ($nome) {
    $ctg = new App\CategoriaProduto();
    $ctg->nome = $nome;
    $ctg->save();
    return redirect("/categoriaproduto");
});

Route::get('/categoriaproduto/buscarprimeiropornome/{nome}', function ($nome) {
    $ctg = App\CategoriaProduto::where('nome', $nome)->first();
      echo 'id: '.$ctg->id .' - nome: '.$ctg->nome . '<br>';
});

Route::get('/categoriaproduto', function () {
    $ctg = App\CategoriaProduto::all();
    foreach ($ctg as $c) {
      echo 'id: '.$c->id .' - nome: '.$c->nome . '<br>';
    }
});

Route::get('/categoriaproduto/buscarpornome/{nome}', function ($nome) {
    $ctg = App\CategoriaProduto::where('nome', $nome)->get();
    foreach ($ctg as $c) {
      echo 'id: '.$c->id .' - nome: '.$c->nome . '<br>';
    }
});

Route::get('/categoriaproduto/buscarporpartedonome/{nome}', function ($nome) {
    $ctg = App\CategoriaProduto::where('nome','like',"%{$nome}%")->orderBy('nome', 'desc')->take(10)->get();
    foreach ($ctg as $c) {
      echo 'id: '.$c->id .' - nome: '.$c->nome . '<br>';
    }
});

Route::get('/categoriaproduto/{id}', function ($id) {
    $ctg = App\CategoriaProduto::find($id);
    if ($ctg)
      echo 'id: '.$ctg->id .' - nome: '.$ctg->nome . '<br>';
    else
      return("Categoria do produto nao encontrada.");
});

Route::get('/categoriaproduto/alterar/{id}/{nome}', function ($id, $nome) {
    $ctg = App\CategoriaProduto::find($id);
    if ($ctg) {
      $ctg->nome = $nome;
      $ctg->save();
      return redirect("/categoriaproduto");
    } else {
      return("Categoria do produto nao encontrada.");
    }
});

Route::get('/categoriaproduto/delete/{id}/', function ($id) {
    $ctg = App\CategoriaProduto::find($id);
    if ($ctg) {
      $ctg->delete();
      return redirect("/categoriaproduto");
    } else {
      return("Categoria do produto nao encontrada.");
    }
});


//===================================================
Route::get('/', function () {
    return view('welcome');
});

//===================================================
return App\Destination::addSelect(['last_flight' =>
  App\Flight::select('name')
      ->whereColumn('destination_id', 'destinations.id')
      ->orderBy('arrived_at', 'desc')
      ->limit(1)
])->get();

//===================================================
return App\Destination::orderByDesc(
    App\Flight::select('arrived_at')
        ->whereColumn('destination_id', 'destinations.id')
        ->orderBy('arrived_at', 'desc')
        ->limit(1)
)->get();

//===================================================
// Retrieve a model by its primary key...
$flight = App\Flight::find(1);
// Retrieve the first model matching the query constraints...
$flight = App\Flight::where('active', 1)->first();
$flights = App\Flight::find([1, 2, 3]);
model = App\Flight::findOrFail(1);
$model = App\Flight::where('legs', '>', 100)->firstOrFail();

//===================================================
$count = App\Flight::where('active', 1)->count();
$max = App\Flight::where('active', 1)->max('price');

//===================================================
// update
App\Flight::where('active', 1)
          ->where('destination', 'San Diego')
          ->update(['delayed' => 1]);

//================================================
// inserir e update

$flight = App\Flight::updateOrCreate(
    ['departure' => 'Oakland', 'destination' => 'San Diego'],
    ['price' => 99, 'discounted' => 1]
);

// inserir um novo registro  e retorna a instância do modelo salva:
$flight = App\Flight::create(['name' => 'Flight 10']);
// Se possui instância, pode usar o fill preenchê-la
$flight->fill(['name' => 'Flight 22']);

// Recupere o voo pelo nome ou crie-o se ele não existir ...
$flight = App\Flight::firstOrCreate(['name' => 'Flight 10']);

// Recupere o voo pelo nome ou crie-o com os atributos name, delayed, e arrival_time ...
$flight = App\Flight::firstOrCreate(
    ['name' => 'Flight 10'],
    ['delayed' => 1, 'arrival_time' => '11:30']
);

// Recupera pelo nome ou instancia ...
$flight = App\Flight::firstOrNew(['name' => 'Flight 10']);

// Recupera por nome ou instancia com os atributos name, delayed, e arrival_time ...
$flight = App\Flight::firstOrNew(
    ['name' => 'Flight 10'],
    ['delayed' => 1, 'arrival_time' => '11:30']
);

//===================================================
// delete
$flight = App\Flight::find(1);
$flight->delete();

// Exclusão de um modelo existente por chave
App\Flight::destroy(1);
App\Flight::destroy(1, 2, 3);
App\Flight::destroy([1, 2, 3]);
App\Flight::destroy(collect([1, 2, 3]));

$deletedRows = App\Flight::where('active', 0)->delete();


//===================================================
// REGISTROS APAGADOS

// Todas Categorias APAGADAS
$cats = App\Categoria::onlyTrashed()->get();

// Restaurado MODELO APAGADO
$cat = App\Categoria::withTrashed()->find($id);
$cat->restore();
App\Flight::withTrashed()->where('airline_id', 1)->restore();

// Todas modelos incluindo apagadas
$cats = App\Categoria::withTrashed()->get();

// buscar por id
$cat = App\Categoria::withTrashed()->find($id);

// ecuperará apenas modelos excluídos virtuais
$flights = App\Flight::onlyTrashed()->where('id', 1)->get();

//===================================================
// Exclusão permanente de modelos

// Exclusão permanente de instancia
$flight->forceDelete();

// Forçar a exclusão de todos os modelos relacionados
$flight->history()->forceDelete();

//===================================================
