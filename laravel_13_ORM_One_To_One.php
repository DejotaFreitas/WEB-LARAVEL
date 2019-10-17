<?php
//===========ROTAS==========================================================
use App\Endereco;
use App\Cliente;


Route::get('/inserir', function () {

    $cli = new Cliente();
    $cli->nome = "Jose Almeida";
    $cli->telefone = "11 98154-5645";
    $cli->save();
    $end = new Endereco();
    $end->rua = "Av. do Estado";
    $end->numero = 400;
    $end->bairro = "Centro";
    $end->cidade = "Sao Paulo";
    $end->uf = "SP";
    $end->cep = "13010-654";
    $cli->endereco()->save($end);

    $cli = new Cliente();
    $cli->nome = "Marcos Silva";
    $cli->telefone = "22 98444-2222";
    $cli->save();
    $end = new Endereco();
    $end->rua = "Av. Brasil";
    $end->numero = 100;
    $end->bairro = "Jardim Olivia";
    $end->cidade = "Sao Paulo";
    $end->uf = "SP";
    $end->cep = "13222-222";
    $cli->endereco()->save($end);

    return "OK";
});


Route::get('/clientes', function () {
    $clientes = Cliente::all();
    foreach($clientes as $c) {
        echo "<p>ID:       " . $c->id . "</p>";
        echo "<p>Nome:     " . $c->nome . "</p>";
        echo "<p>Telefone: " . $c->telefone . "</p>";
        echo "<p>Rua:      " . $c->endereco->rua . "</p>";
        echo "<p>Numero:   " . $c->endereco->numero . "</p>";
        echo "<p>Bairro:   " . $c->endereco->bairro . "</p>";
        echo "<p>Cidade:   " . $c->endereco->cidade . "</p>";
        echo "<p>UF:       " . $c->endereco->uf . "</p>";
        echo "<p>Cidade:   " . $c->endereco->cidade . "</p>";
        echo "<p>CEP:      " . $c->endereco->cep . "</p>";
        echo "<hr>";
    }
});

Route::get('/enderecos', function () {
    $enderecos = Endereco::all();
    foreach($enderecos as $e) {
        echo "<p>Cliente ID:       " . $e->cliente->id . "</p>";
				echo "<p>Cliente nome:     " . $e->cliente->nome . "</p>";
				echo "<p>Cliente telefone: " . $e->cliente->telefone . "</p>";
				echo "<p>Endereco ID:      " . $e->cliente_id . "</p>";
        echo "<p>Nome:     " . $e->nome . "</p>";
        echo "<p>Telefone: " . $e->telefone . "</p>";
        echo "<p>Rua:      " . $e->rua . "</p>";
        echo "<p>Numero:   " . $e->numero . "</p>";
        echo "<p>Bairro:   " . $e->bairro . "</p>";
        echo "<p>Cidade:   " . $e->cidade . "</p>";
        echo "<p>UF:       " . $e->uf . "</p>";
        echo "<p>Cidade:   " . $e->cidade . "</p>";
        echo "<p>CEP:      " . $e->cep . "</p>";
        echo "<hr>";
    }
});


Route::get('/clientes/json', function () {
  // Lazy Loading
    // nao tras os enderecos, somente se acessar o atributo endereco
    // $clientes = Cliente::all();

    // Eager Loading
    // forçar o carregamento do endereços no momento da pesquisa
    $clientes = Cliente::with(['endereco'])->get();
    return $clientes->toJson();
});


Route::get('/enderecos/json', function () {
  // Lazy Loading
  // nao tras os cliente, somente se acessar o atributo cliente
  // $enderecos = Endereco::all();

  // Eager Loading
  // forçar o carregamento dos clientes no momento da pesquisa
  $enderecos = Endereco::with(['cliente'])->get();
    return $enderecos->toJson();
});



//==============MODEL=======================================================
class Cliente extends Model
{
	public function endereco()
	 {
			 return $this->hasOne('App\Endereco');
	 }
}

class Endereco extends Model
{
    function cliente() {
      // pertence a
        return $this->belongsTo('App\Cliente');
    }
}
//=================MIGRATOIN====================================================
class CreateClientesTable extends Migration {
    public function up()  {
      Schema::create('clientes', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nome');
          $table->string('telefone');
          $table->timestamps();
      });
    }
}


class CreateEnderecos extends Migration {
    public function up()  {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->integer('cliente_id')->unsigned();
            $table->primary('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string('rua');
            $table->integer('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('uf');
            $table->string('cep');
            $table->timestamps();
        });
    }
}


//=====================================================================
//=====================================================================
//=====================================================================
// ============== Um para um (polimórfico) ==============
posts
    id - integer
    name - string

users
    id - integer
    name - string

images
    id - integer
    url - string
    imageable_id - integer
    imageable_type - string

//=====================================================================
class Image extends Model
{
    public function imageable()
    {
        return $this->morphTo();
    }
}

class Post extends Model
{
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
}

class User extends Model
{
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
}


//=====================================================================
$post = App\Post::find(1);
$image = $post->image;

$image = App\Image::find(1);
$imageable = $image->imageable;


//=====================================================================
