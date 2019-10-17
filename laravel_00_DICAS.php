<?php
// ===========================================================================

// ===========================================================================
// enviar PUT atraves formulario
?>
<form action="/foo/bar" method="POST">

    <input type="hidden" name="_method" value="PUT">
    <!-- OU ASSIM -->
    {{ method_field('PUT') }}

</form>
<?php

// ===========================================================================
// CSRF
?>
<html>
    <head>
        <!-- token para altenticação da pagina -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
      <form action="salvar" method="post">

        <!-- token de validacao do formulario -->
        @csrf
        <!-- OU ASSIM -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">


      </form>
    </body>
</html>
<?php

// ===========================================================================
// softDeletes
// PERMITE CRIAR QUE O CONTEUDO DO DATABASE SEJA DESATIVADA E NAO DELETADA

// Migration
class CreateCategoriasTable extends Migration {
    public function up()    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->softDeletes(); // ########softDeletes#########
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}

// Model
class Categoria extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
