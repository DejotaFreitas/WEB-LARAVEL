<?php
// CONTROLLER

class ClienteControlador extends Controller
{
    public function index()
    {
        $clientes = App\Cliente::all();  return view ('clientes', compact('clientes'));
    }

    public function create()  {  return view('novocliente');  }

    public function store(Request $request)
    {
      // VALIDAÇÕES
      /*
      bail // PARA VALIDAÇÃO APOS A PRIMEIRA FALHA
      required //CAMPO REQUERIDO
      required_if: outro campo , valor , ... // REQUERIDO SE OUTRO CAMPO TIVER UM VALOR TAL
      required_unless: outro campo , valor , ... // SO PODER SER VAZIO SE OUTRO CAMPO TIVER VALOR
      min:1 // TAMANHO MINIMO, , EM NUMERO CORRESPONDE AO VALOR, EM TEXTO A QUANTODADE DE CARACTERES
      max:10 // TAMANHO MAXIMO, EM NUMERO CORRESPONDE AO VALOR, EM TEXTO A QUANTODADE DE CARACTERES
      numeric // SOMENTE NUMEROS
      alpha // SOMENTE CARACTERES ALFABETICOS
      alpha_num // // SOMENTE LETRAS E NUMEROS
      alpha_dash // SOMENTE LETRAS, NUMEROS, TRAÇO -, UNDERLINE _
      confirmed // SE O CAMPO SOB VALIDAÇÃO FOR name='password', UM CAMPO name='password_confirmation' DEVERÁ ESTAR PRESENTE NA ENTRADA
      date // DATA
      unique:table,column,except,idColumn // NÃO DEVE EXISTIR OUTRO NA TABELA DE BANCO DE DADOS
      email:rfc,dns' // RFC: RFCVALIDATION, STRICT: NORFCWARNINGSVALIDATION, DNS: DNSCHECKVALIDATION, SPOOF: SPOOFCHECKVALIDATION, FILTER: FILTEREMAILVALIDATION
      file  // DEVE SER UM ARQUIVO CARREGADO COM SUCESSO.
      image // DEVE SER UMA IMAGEM (JPEG, PNG, BMP, GIF, SVG OU WEBP)
      in:foo,bar,... //DEVE TA CONTIDO NA LISTA
      accepted // MARCARAM CAIXA COMO EM ACEITAR TERMOS DE SERVIÇO
      active_url // URL ATIVA
      ip    // IP VALIDO
      ipv4  // IPV4 VALIDO
      ipv6  // IPV6 VALIDO
      json // JSON VALIDO
      url // O CAMPO EM VALIDAÇÃO DEVE SER UM URL VÁLIDO.
      nullable // PODEM SER NULOS
      present // O NOME DO IMPUTE DEVE ESTAR PRESENTE, MESMO QUE ESTEJA VAZIO
      regex:^.+$/i // DEVE CORREPONDER A EXPRESSAO REGULAR
      not_regex:^.+$/i // NÃO DEVE CORREPONDER A EXPRESSAO REGULAR
      in: foo,bar // VALOR DEVE ESTAR CONTIDO NA LISTA
      not_in:foo,bar // VALOR NAO DEVE ESTAR CONTIDO NA LISTA
      mimes:jpeg,bmp,png // ARQUIVO DEVE TER O FORMATO
      mimetypes:video/avi,video/mpeg,video/quicktime // DEVE CORRESPONDER AO MIME
      required_with: foo , bar , ... // REQUERIDO A MENOS QUE UM DOS OUTROS CAMPOS ESTEJA PRESENTE
      required_with_all: foo , bar , ... // REQUERIDO A MENOS QUE TODOS OS CAMPOS ESTEJAM PRESENTE
      required_without: foo , bar , ... //REQUERIDO A MENOS QUE UM DOS OUTROS CAMPOS NÃO ESTEJA PRESENTE
      required_without_all: foo , bar , ... REQUERIDO A MENOS QUE TODOS OS CAMPOS NÃO ESTEJAM PRESENTE
      same:field // O CAMPO FORNECIDO DEVE CORRESPONDER OO CAMPO SOB VALIDACAO
      begin_with: foo , bar , ... // O CAMPO SOB VALIDAÇÃO DEVE COMEÇAR COM UM DOS VALORES FORNECIDOS.
      size:value // CORREPONDER AO TAMNHO count() | ARQUIVOS TAMANHO EM KILOBYTES
      digits:value // DEVE SER NUMÉRICO E DEVE TER UM TAMANHO EXATO DE VALOR .
      digits_between:min,max
      ends_with: foo , bar , ...
      dimensions:min_width, max_width, min_height, max_height, width, height, ratio
      dimensions:min_width=100,min_height=200 // DIMENSOES IMAGEM
      different:field // DEVE SER DIFRENTE
      date_format:format //
      date_equals:date //
      boolean // É UM BOOL ENTRE true, false, 1, 0, "1", e "0".
      between:min,max // ENTRE MAXIMOE MINIMO
      matriz // ARRAY PHP
      exists:table,column // DEVE EXISTIR EM UMA DETERMINADA TABELA DE BANCO DE DADOS.
      string // CAMPO DEVE SER UMA STRING

      */

      // ADD MENSAGEM DE ERRO MANUALMENTE PARA ERROS PERSONALIZADOS
      // $validator->errors()->add('campo', 'tem algo de errado nesse campo!');

      $regras = [
          'nome'  => 'bail|alpha|required|min:3|max:20',
          'idade' => 'bail|required|numeric|min:1|max:200|digits_between:1,10',
          'email' => 'bail|required|email|unique:clientes,email'
      ];
      $mensagens = [
          'required' => 'O atributo :attribute não pode estar em branco.',  // Generico
          'nome.alpha' => 'Use somente letras de A a Z.',
          'nome.min' => 'É necessário no mínimo 3 caracteres no nome.',
          'digits_between' => 'Deve ter entre 1 a 10 caracteres.',
          'email.required' => 'Digite um endereço de email.',
          'email.email' => 'Digite um endereço de email válido',
          'email.unique' => 'Email já está em uso.'
      ];
      $request->validate($regras, $mensagens);

      $cli = new Cliente();
      $cli->nome     = $request->input('nome');
      $cli->idade    = $request->input('idade');
      $cli->email    = $request->input('email');
      $cli->save();
      return redirect('/');;
    }
}

//==================================================================
// HTML FORMULARIO RECEBENDO AS MENSAGENS DE ERROS
?>

<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Pagina de Clientes</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<style>
		body { padding: 20px; }
	</style>
</head>
<body>

  <main role="main">
    <div class="row">
      <div class="container  col-sm-8 offset-md-2">
        <div class="card border">
          <div class="card-header">
            <h5 class="card-title">Cadastro de Cliente</h5>
          </div>
          <div class="card-body">
            <form action="/cliente" method="POST">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">
                <label for="nome">Nome do Cliente</label>
                <input type="text"
                       class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}"
                       name="nome"  id="nome" placeholder="Nome do Cliente" value="{{ old('nome') }}">
@if ($errors->has('nome'))
                <div class="invalid-feedback">
  {{ $errors->first('nome') }}
                </div>
@endif
              </div>
              <div class="form-group">
                <label for="idade">Idade do Cliente</label>
                <input type="number"
                       class="form-control {{ $errors->has('idade') ? 'is-invalid' : '' }}"
                       name="idade"  id="idade" placeholder="Idade do Cliente" value="{{ old('idade') }}">
@if ($errors->has('idade'))
                <div class="invalid-feedback">
  {{ $errors->first('idade') }}
                </div>
@endif
              </div>
              <div class="form-group">
                <label for="endereco">Email</label>
                <input type="text"
                       class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       name="email"  id="email" placeholder="E-mail do Cliente" value="{{ old('email') }}">
@if ($errors->has('email'))
                <div class="invalid-feedback">
  {{ $errors->first('email') }}
                </div>
@endif
              </div>
              <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
              <button type="reset" class="btn btn-danger btn-sm">Cancelar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

</body>
</html>
