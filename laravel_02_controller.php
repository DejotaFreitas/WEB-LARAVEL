<?php
// criar esse controle com metodo prontos
// php artisan make:controller ClienteControler --resource

//adiciona rota
// Route::resource('/cliente', 'ClienteControler');

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteControler extends Controller
{
    // GET|HEAD .../cliente
    public function index()
    {
        // PAGINA RAIZ DA ROTA
        return "Lista de todos os clientes";
    }

    // GET|HEAD .../cliente/create
    public function create()
    {
        // ENVIAR FORMULARIO PARA CLIENTE
        return "formulario para cadastrar cliente";
        // return view('formulario_cadastro_cliente');
    }

    // POST .../cliente
    public function store(Request $request)
    {
        // RECEBER DADOS DO FORMULARIO ENVIADO PELO CLIENTE
        // POST  NA URL PADRAO .../cliente
        $dados = "Nome ".$request->input('nome');
        $dados .= "Sobrenome ".$request->input('sobrenome');
        // 201 codigo que foi criado com sucesso
        return reponse($dados, 201);
    }

    // GET|HEAD .../cliente/1
    public function show($id)
    {
        // MOSTRA O CLIENTE PELO ID - EX: .../1
        $v = [ "Mario", "Edson", "Roberto", "Joao" ];
        if ($id < count($v) && $id >= 0)
            return $v[ $id ];
        return "Nao encontrado";
    }

    // GET|HEAD  .../cliente/1/edit
    public function edit($id)
    {
        // ENVIAR FORMULARIO PARA EDITAR CLIENTE PELO ID
        return "Formulario para Editar cliente com ID " . $id;
    }

    // PUT|PATCH .../cliente/1
    // POST -> no formulario envia campo com name: _method value: PUT ou PATCH
    // <input type="hidden" name="_method" value="PUT">
    public function update(Request $request, $id)
    {
        // RECEBER DADOS DO FORMULARIO DO CLIENTE SERA EDITADO PELO ID
        // Armazenar os dados
        $s  = "Atualizar Cliente com id " . $id . ": ";
        $s .= "Nome: "  . $request->input('nome') . " e ";
        $s .= "Idade: " . $request->input('idade');
        return response($s, 200);
    }

    // DELETE .../cliente/1
    public function destroy($id)
    {
        // DELETAR ALGUM CLIENTE
        return response("Apagado Cliente com ID " . $id, 200);
    }

}
