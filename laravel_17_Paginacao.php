<?php
//==================ROUTE===================================================
Route::get('/', 'ClienteControlador@index');
Route::get('/indexjs', 'ClienteControlador@indexjs');
Route::get('/json', 'ClienteControlador@indexjson');

//===================CONTROLLER==================================================
use App\Cliente;
class ClienteControlador extends Controller
{
    public function index()  {
      $clientes = Cliente::paginate(10);
      return view('index', compact(['clientes']));
    }

    public function indexjs()    {
        return view('indexjs');
    }

    public function indexjson()    {
        return Cliente::paginate(10);
    }

}

//==================PAGINACAO=RECARREGANDO=PAGINA======================
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Paginação</title>

      <!-- token de autenticação da pagina -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <!-- add bootstrap compilado -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

    </head>
    <body>

      <!-- // codigo html.... -->
      <div class="container">
    <div class="card text-center">
      <div class="card-header">
       	Tabela de Clientes
      </div>
      <div class="card-body">

        <h5 class="card-title">Exibindo {{$clientes->count()}} clientes de {{$clientes->total()}}
        ( {{$clientes->firstItem()}} a {{$clientes->lastItem()}} ) </h5>

        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nome</th>
              <th scope="col">Sobrenome</th>
              <th scope="col">Email</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clientes as $cliente)
            <tr>
              <th scope="row">{{$cliente->id}}</th>
              <td>{{$cliente->nome}}</td>
              <td>{{$cliente->sobrenome}}Otto</td>
              <td>{{$cliente->email}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="card-footer">
        {{ $clientes->links() }}
      </div>

    </div>

  </div>

      <!-- add javascript do bootstrap compilado -->
      <script src="{{asset('js/app.js')}}" charset="utf-8" type="text/javascript"></script>

    </body>
</html>





<?php
//========================PAGINACAO=USANDO=JAVASCRIPT======================
?>
<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Pagina de Produtos</title>
    <style>
        body {  padding: 20px;  }
        .navbar {  margin-bottom: 20px;  }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

  <div class="container">
    <div class="card text-center">

      <div class="card-header">
       	Tabela de Clientes
      </div>

      <div class="card-body">
        <h5 class="card-title" id="cardtitle"></h5>

        <table class="table table-hover" id="tabelaClientes">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nome</th>
              <th scope="col">Sobrenome</th>
              <th scope="col">Email</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="card-footer">

        <nav id="paginationNav">
          <ul class="pagination">
          </ul>
        </nav>

<!--
        <nav id="paginationNav">
          <ul class="pagination">
            <li class="page-item disabled">
              <a class="page-link" href="#">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active">
              <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
-->

      </div>
    </div>

  </div>

  <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

  <script type="text/javascript">

    function getNextItem(data) {
        i = data.current_page+1;
        if (data.current_page == data.last_page)
            s = '<li class="page-item disabled">';
        else
            s = '<li class="page-item">';
        s += '<a class="page-link" ' + 'pagina="'+i+'" ' + ' href="javascript:void(0);">Próximo</a></li>';
        return s;
    }

    function getPreviousItem(data) {
        i = data.current_page-1;
        if (data.current_page == 1)
            s = '<li class="page-item disabled">';
        else
            s = '<li class="page-item">';
        s += '<a class="page-link" ' + 'pagina="'+i+'" ' + ' href="javascript:void(0);">Anterior</a></li>';
        return s;
    }

    function getItem(data, i) {
        if (data.current_page == i)
            s = '<li class="page-item active">';
        else
            s = '<li class="page-item">';
        s += '<a class="page-link" ' + 'pagina="'+i+'" ' + ' href="javascript:void(0);">' + i + '</a></li>';
        return s;
    }

    function montarPaginator(data) {

        $("#paginationNav>ul>li").remove();

        $("#paginationNav>ul").append(
            getPreviousItem(data)
        );
        
        // for (i=1;i<=data.last_page;i++) {
        //     $("#paginationNav>ul").append(
        //         getItem(data,i)
        //     );
        // }

        n = 10;

        if (data.current_page - n/2 <= 1)
            inicio = 1;
        else if (data.last_page - data.current_page < n)
            inicio = data.last_page - n + 1;
        else
            inicio = data.current_page - n/2;

        fim = inicio + n-1;

        for (i=inicio;i<=fim;i++) {
            $("#paginationNav>ul").append(
                getItem(data,i)
            );
        }
        $("#paginationNav>ul").append(
            getNextItem(data)
        );
    }

    function montarLinha(cliente) {
        return '<tr>' +
            '  <th scope="row">' + cliente.id + '</th>' +
            '  <td>' + cliente.nome + '</td>' +
            '  <td>' + cliente.sobrenome + '</td>' +
            '  <td>' + cliente.email + '</td>' +
            '</tr>';
    }

    function montarTabela(data) {
        $("#tabelaClientes>tbody>tr").remove();
        for(i=0;i<data.data.length;i++) {
            $("#tabelaClientes>tbody").append(
                montarLinha(data.data[i])
            );
        }
    }

    function carregarClientes(pagina) {
        $.get('/json',{page: pagina}, function(resp) {
            console.log(resp);
            console.log(resp.data.length);
            montarTabela(resp);
            montarPaginator(resp);
            $("#paginationNav>ul>li>a").click(function(){
                // console.log($(this).attr('pagina') );
                carregarClientes($(this).attr('pagina'));
            })
            $("#cardtitle").html( "Exibindo " + resp.per_page +
                " clientes de " + resp.total +
                " (" + resp.from + " a " + resp.to +  ")" );
        });
    }

    $(function(){
        carregarClientes(1);
    });

  </script>

</body>
</html>
