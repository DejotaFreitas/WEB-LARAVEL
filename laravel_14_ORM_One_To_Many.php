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
    $end->cliente()->associate($cli);
    // $end->cliente()->dissociate();
    $end->save();

    $end2 = new Endereco();
    $end2->rua = "Av. Brasil";
    $end2->numero = 100;
    $end2->bairro = "Jardim Olivia";
    $end2->cidade = "Sao Paulo";
    $end2->uf = "SP";
    $end2->cep = "13222-222";
    $end2->cliente()->associate($cli);
    // $end2->cliente()->dissociate();
    $end2->save();

    return "OK";
});



Route::get('/clientes', function () {
  // Lazy Loading
    // nao tras os enderecos, somente se acessar o atributo endereco
    // $clientes = Cliente::all();

    // Eager Loading
    // forçar o carregamento do endereços no momento da pesquisa
    $clientes = Cliente::with(['endereco'])->get();
    return $clientes->toJson();
});


Route::get('/enderecos', function () {
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
			 return $this->hasMany('App\Endereco');
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
            $table->increments('id');
            $table->integer('cliente_id')->unsigned()->nullable();
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
    title - string
    body - text

videos
    id - integer
    title - string
    url - string

comments
    id - integer
    body - text
    commentable_id - integer
    commentable_type - string

//=====================================================================
class Comment extends Model
{
    public function commentable()
    {
        return $this->morphTo();
    }
}

class Post extends Model
{
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}

class Video extends Model
{
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}


//=====================================================================
$post = App\Post::find(1);
foreach ($post->comments as $comment) {}

  $comment = App\Comment::find(1);  
  $commentable = $comment->commentable;
//=====================================================================
