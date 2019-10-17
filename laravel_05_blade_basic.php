//===================Layouts=Blade==================================

Route::get('/layout1', function () {
    return view('layoutfilho');
});

//====================Blade=PAI=================================
<!-- Dentro diretorio das view views/layouts/layoutpai.blade.php -->

<html>
    <head>
        <title>Titulo Principal - @yield('titulo')</title>
        <!-- token de autenticação da pagina -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        @section('barralateral')
            Esta parte da seção é do template PAI.
        @show

        <div>
            @yield('conteudo')
        </div>
    </body>
</html>

//====================Blade=FILHA=================================
<!-- view que herda do pai views/layoutfilho.blade.php -->

<!-- herda layout do pái -->
@extends('layouts.layoutpai')

<!-- adiciona titulo pesonalizado para cada pagina -->
@section('titulo', 'Minha Página')

<!-- subistitui a barralateral do pai -->
@section('barralateral')
<!-- @parent chama a conteudo da barralateral do pai -->
    @parent
    <p>Essa parte é do FILHO.</p>
    @parent
@endsection

@section('conteudo')
    <p>Este é o conteúdo do filho.</p>
@endsection


//======================================================
//=====================IF=================================
<!-- controle -->
public function listar() {
     $produtos = [
         "Notebook Asus i7 16GB 1TB SSD",
         "Mouse e Teclado Microsoft USB",
         "Monitor 21 - Samsung",
         "Impressora HP",
         "Disco SSD 512 GB"
     ];
     // return view('if_produtos');
     return view('if_produtos', compact('produtos'));
 }

<!-- view -->
@if (isset($produtos))

        @if (count($produtos) === 0)
            <h1>Nenhum produto</h1>
        @elseif (count($produtos) === 1)
            <h1>1 produto</h1>
        @else
            <h1>Vários produtos</h1>
        @endif

    @else
        <h2>Variável produtos não foi passada como parâmetro</h2>
    @endif

    @empty($produtos)
        <h2>Nada em produtos</h2>
    @endempty

//=====================FOREACH=================================

    @foreach($produtos as $p)
        <p>{{ $p['id'] }}: {{ $p['nome'] }} </p>
    @endforeach

    <hr>
    @foreach($produtos as $p)
        <p>
            {{ $p['id'] }}: {{ $p['nome'] }}
            @if ($loop->first)
                (primeiro)
            @endif
            @if ($loop->last)
                (ultimo)
            @endif
            <span class="badge badge-secondary">{{ $loop->index}}  / {{ $loop->count }} / {{ $loop->remaining }}</span>
            <span class="badge badge-secondary">{{ $loop->iteration}}  / {{ $loop->count }}</span>
        </p>
    @endforeach

//=====================FOR=================================

    @for($i=0; $i < $n; $i++)
        <p>Numero {{$i}} </p>
    @endfor

//=====================FOR=BREAK=CONTINUE===============================
    @foreach ($blogs as $blog)
        @if (!$blog->is_validated)
            @continue
        @endif
        <li>{{ $blog->title }}</li>
        @if ($blog->is_last)
            @break
        @endif
    @endforeach

//=====================FORELSE=================================

    @forelse ($blogs as $blog)
        <li>{{ $blog->title }}</li>
    @empty
        <p>There are no blogs.</p>
    @endforelse

//=====================switch=================================

    @switch($opcao)
                @case(1)
                    <span class="badge badge-primary">Azul</span>
                    @break
                @case(2)
                    <span class="badge badge-danger">Vermelho</span>
                    @break
                @case(3)
                    <span class="badge badge-success">Verde</span>
                    @break
                @case(4)
                    <span class="badge badge-warning">Amarelo</span>
                    @break
                @default
                    <span class="badge badge-dark">Outra cor</span>
            @endswitch

//=====================hasSection=================================

@hasSection('secao_produtos')
        <div class="card" style="width: 500px; margin: 10px;">
            <div class="card-body">
                <h5 class="card-title">Produtos</h5>
                <p class="card-text">
                    @yield('secao_produtos')
                </p>
                <a href="#" class="card-link">Informações</a>
                <a href="#" class="card-link">Ajuda</a>
            </div>
        </div>
    @endif

//======================================================
@guest
    // deslogado
@endguest

@auth
    // logado
@endauth

//=======================STACK=PUSH==============================
<head>
      @stack('scripts')
</head>

@push('scripts')
    <script src="/example.js"></script>
@endpush

//======================================================


//======================================================


//======================================================


//======================================================


//======================================================


//======================================================


//======================================================


//======================================================
