<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your appliuserion. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\DB;

Route::get('/users', function () {
    //1o esse-> var_dump($users);

    //
    $users = DB::table('users')->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }

    // retorna um array com todos os names
    $names = DB::table('users')->pluck('name');
    foreach($names as $n)
        echo "$n <br>";

    // retorna um array com id=1
    $users = DB::table('users')->where('id',1)->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }

    // retorna um unico elemento
    $user = DB::table('users')->where('id',1)->first();
    if (isset($user)) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }


    // retorna um array utilizando like
    echo "<p>Retorna um array utilizando like";
    $users = DB::table('users')->where('name','like','%p%')->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }

    // utilizando sentença lógica
    echo "<p>Sentenças lógicas";
    $users = DB::table('users')->where('id','1')->orWhere('id',2)->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }

    // utilizando intervalos
    echo "<p>utilizando intervalos";
    $users = DB::table('users')->whereBetween('id',[2,3])->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }
    echo "<p>utilizando intervalos";
    $users = DB::table('users')->whereNotBetween('id',[2,3])->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }

    // utilizando conjunto de valores
    echo "<p>utilizando conjunto de valores";
    $users = DB::table('users')->whereIn('id', [1, 2, 3])->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }
    echo "<p>utilizando conjunto de valores";
    $users = DB::table('users')->whereNotIn('id', [1, 2, 3])->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }

    // order by
    echo "<p>order by name";
    $users = DB::table('users')->orderBy('name')->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }
    echo "<p>order by name (desc)";
    $users = DB::table('users')->orderBy('name', 'desc')->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }

});


Route::get('/newusers', function () {

    //inserindo um único registro
    DB::table('users')->insert(
        ['name' => 'Alimentos']
    );
    //inserindo varios
    DB::table('users')->insert([
        ['name' => 'Cama, mesa e banho'],
        ['name' => 'Informática'],
        ['name' => 'Cozinha'],
    ]);
    //recuperando id do registro inserido
    $id = DB::table('users')->insertGetId(
        ['name' => 'Utensílios domésticos']
    );
    echo $id;

});


Route::get('/updateusers', function () {

    $user = DB::table('users')->where('id',1)->first();
    echo "<p> Antes-> name: " . $user->name . "</p>";

    //atualizando registros
    DB::table('users')->where('id',1)
        ->update (['name' => 'Roupas Infantis']);

    $user = DB::table('users')->where('id',1)->first();
    echo "<p> Depois-> name: " . $user->name . "</p>";
});



Route::get('deleteusers', function () {

    echo "<p> Antes:  </p>";
    $users = DB::table('users')->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }

    //apagando registros
    DB::table('users')->where('id',1)->delete();
    DB::table('users')->whereNotIn('id', [1, 2, 3])->delete();

    echo "<p> Depois:  </p>";
    $users = DB::table('users')->get();
    foreach($users as $user) {
        echo "id: " . $user->id . ", ";
        echo "name: " . $user->name . "<br>";
    }
});



//===================================================


// Inserts
DB::table('users')->insert(['email' => 'john@example.com', 'votes' => 0]);
DB::table('users')->insert([
    ['email' => 'taylor@example.com', 'votes' => 0],
    ['email' => 'dayle@example.com', 'votes' => 0]
]);
// ignorará erros de registro duplicado
DB::table('users')->insertOrIgnore([
    ['id' => 1, 'email' => 'taylor@example.com'],
    ['id' => 2, 'email' => 'dayle@example.com']
]);
// inserir um registro e recuperar o ID
$id = DB::table('users')->insertGetId(['email' => 'john@example.com', 'votes' => 0]);

//============================================================================
// Updates
$affected = DB::table('users')->where('id', 1)->update(['votes' => 1]);
DB::table('users')->updateOrInsert(
  ['email' => 'john@example.com', 'name' => 'John'],
  ['votes' => '2']
);

//============================================================================
// Deletes
DB::table('users')->delete();
DB::table('users')->where('votes', '>', 100)->delete();
// removerá todas as linhas e redefinirá o ID de incremento automático para zero
DB::table('users')->truncate();

//============================================================================
// Incremento e Decremento
DB::table('users')->increment('votes');
DB::table('users')->increment('votes', 5);
DB::table('users')->decrement('votes');
DB::table('users')->decrement('votes', 5);

//============================================================================

// chunk traz os resultado por parte para evitar cosumo de memoria
// muito util  quando tem milhares de registros do banco de dados
DB::table('users')->orderBy('id')->chunk(100, function ($users) {
    foreach ($users as $user) {}
});

// cancelar o carregamento do chunk = return false;
DB::table('users')->orderBy('id')->chunk(100, function ($users) {
    $parar_de_carregar = true;
    if ($parar_de_carregar) {  return false;  }
});

// Se você estiver atualizando os registros do banco de dados enquanto chunking os resultados,
DB::table('users')->where('active', false)
    ->chunkById(100, function ($users) {
        foreach ($users as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['active' => true]);
        }
    });

//============================================================================

// pegar email quando name for John
$email = DB::table('users')->where('name', 'John')->value('email');

// count, max, min, avg, e sum.
$users = DB::table('users')->count();
$price = DB::table('orders')->max('price');
$price = DB::table('orders')->where('finalized', 1)->avg('price');

// exist ? nao exist ?
return DB::table('orders')->where('finalized', 1)->exists();
return DB::table('orders')->where('finalized', 1)->doesntExist();

// RENOMEAR
$users = DB::table('users')->select('email as user_email')->get();

//============================================================================
// WHERE
$users = DB::table('users')->where('votes', '=', 100)->get();
$users = DB::table('users')->where('votes', 100)->get();
$users = DB::table('users')->where('votes', '>=', 100)->get();
$users = DB::table('users')->where('votes', '<>', 100)->get();
$users = DB::table('users')->where('name', 'like', '%T%')->get();
$users = DB::table('users')->where([['status', '=', '1'],['subscribed', '<>', '1']])->get();
$users = DB::table('users')->where('votes', '>', 100)->orWhere('name', 'John')->get(); // OR
$users = DB::table('users')->whereBetween('votes', [1, 100])->get(); // AND
$users = DB::table('users')->whereNotBetween('votes', [1, 100])->get();
$users = DB::table('users')->orWhereNotBetween('votes', [1, 100])->get();
$users = DB::table('users')->whereIn('id', [1, 2, 3])->get();
$users = DB::table('users')->whereNotIn ('id', [1, 2, 3])->get();
$users = DB::table('users')->orWhereIn ('id', [1, 2, 3])->get();
$users = DB::table('users')->orWhereNotIn('id', [1, 2, 3])->get();
$users = DB::table('users')->whereNull('updated_at')->get();
$users = DB::table('users')->whereNotNull('updated_at')->get();
$users = DB::table('users')->whereDate('created_at', '2016-12-31')->get();
$users = DB::table('users')->whereYear('created_at', '2016')->get();
$users = DB::table('users')->whereMonth('created_at', '12')->get();
$users = DB::table('users')->whereDay('created_at', '31')->get();
$users = DB::table('users')->whereTime('created_at', '=', '11:20:45')->get();
$users = DB::table('users')->whereColumn('first_name', 'last_name')->get();
$users = DB::table('users')->where('name', '=', 'John')->where(function ($query) {
    $query->where('votes', '>', 100)->orWhere('title', '=', 'Admin');
})->get();

//============================================================================
// join
$users = DB::table('users')
->join('contacts', 'users.id', '=', 'contacts.user_id')
->join('orders', 'users.id', '=', 'orders.user_id')
->select('users.*', 'contacts.phone', 'orders.price')
->get();

// leftJoin
$users = DB::table('users')
->leftJoin('posts', 'users.id', '=', 'posts.user_id')
->get();

// rightJoin
$users = DB::table('users')
->rightJoin('posts', 'users.id', '=', 'posts.user_id')
->get();

// Join Clause
DB::table('users')
->join('contacts', function ($join) {
    $join->on('users.id', '=', 'contacts.user_id')->orOn(...);})
->get();

// Join wheree orWhere
DB::table('users')
->join('contacts', function ($join) {
$join->on('users.id', '=', 'contacts.user_id')
->where('contacts.user_id', '>', 5);})
->get();

//============================================================================
// FORÇAR SELECT
$users = DB::table('users')
->select(DB::raw('count(*) as user_count, status'))
->where('status', '<>', 1)
->groupBy('status')
->get();

// havingRawe orHavingRaw
$orders = DB::table('orders')
->select('department', DB::raw('SUM(price) as total_sales'))
->groupBy('department')
->havingRaw('SUM(price) > ?', [2500])
->get();

// groupBy / having
$users = DB::table('users')->groupBy('account_id')->having('account_id', '>', 100)->get();

//  buscar um usuário aleatório:
$randomUser = DB::table('users')->inRandomOrder()->first();

// limitar a quantidade de resultado da pesquisa
$users = DB::table('users')->take(5)->get();
$users = DB::table('users')->limit(5)->get();

// ignorar os primeiros 10
$users = DB::table('users')->skip(10)->get();
$users = DB::table('users')->offset(10)->get();

//============================================================================
// Depuração
DB::table('users')->where('votes', '>', 100)->dd();
DB::table('users')->where('votes', '>', 100)->dump();
