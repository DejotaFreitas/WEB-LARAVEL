<?php
//==============ROUTE=======================================================
$x = Cliente::find(4);

// adicionar enderecos ao cliente
$x->enderecos()->attach(1);
$x->enderecos()->attach(2);
$x->enderecos()->attach(3);

// remover enderecos do cliente
$x->enderecos()->detach(1);
$x->enderecos()->detach(2);
$x->enderecos()->detach(3);


//==============MODEL=======================================================
class Cliente extends Model {
	public function enderecos() {
			 return $this->belongsToMany('App\Endereco');
	 }
}

class Endereco extends Model {
    function clientes() {
        return $this->belongsToMany('App\Cliente');
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


class CreateEnderecosTable extends Migration {
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


class CreateClientesEnderecosTable extends Migration
{
    public function up()
    {
      Schema::create('clientes_enderecos', function (Blueprint $table) {
        $table->integer('cliente_id')->unsigned();
        $table->integer('endereco_id')->unsigned();
        $table->foreign('cliente_id')->references('id')->on('clientes');
        $table->foreign('endereco_id')->references('id')->on('enderecos');
        $table->primary(['endereco_id', 'cliente_id']);
        $table->timestamps();
		    });
    }


//=====================================================================
//=====================================================================
//=====================================================================
// ============== tabela intermediária personalizados ==============
class Role extends Model {
    public function users()  {
        return $this->belongsToMany('App\User')->using('App\RoleUser');
    }
}

class User extends Model {
    public function users() {
        return $this->belongsToMany('App\Role')->using('App\RoleUser');
    }
}

class RoleUser extends Pivot
{

}

//=====================================================================
//=====================================================================
//=====================================================================
// ============== Tem um através de ==============
users
    id - integer
    supplier_id - integer

suppliers
    id - integer

history
    id - integer
    user_id - integer


//=====================================================================
class Supplier extends Model {
    public function userHistory()    {
        // Tem um 'History' através de 'User'
        return $this->hasOneThrough('App\History', 'App\User');
    }
}

//=====================================================================
//=====================================================================
//=====================================================================
// ============== Tem muitos através de ==============
countries
    id - integer
    name - string

users
    id - integer
    country_id - integer
    name - string

posts
    id - integer
    user_id - integer
    title - string

//=====================================================================
class Country extends Model {
    public function posts()  {
        // Tem muitos 'Post' através de 'User'
        return $this->hasManyThrough('App\Post', 'App\User');
    }
}

//=====================================================================
//=====================================================================
//=====================================================================
// ============== Um para um (polimórfico) ==============
posts
    id - integer
    name - string

videos
    id - integer
    name - string

tags
    id - integer
    name - string

taggables
    tag_id - integer
    taggable_id - integer
    taggable_type - string

//=====================================================================
class Post extends Model
{
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }
}

class Tag extends Model
{
    public function posts()  {
        return $this->morphedByMany('App\Post', 'taggable');
    }
    public function videos()  {
        return $this->morphedByMany('App\Video', 'taggable');
    }
}

//=====================================================================
$post = App\Post::find(1);
foreach ($post->tags as $tag) {}

	$tag = App\Tag::find(1);
	foreach ($tag->videos as $video) {}
//=====================================================================
