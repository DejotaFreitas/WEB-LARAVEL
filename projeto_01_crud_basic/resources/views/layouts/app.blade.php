<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cadastro</title>

        <!-- token de autenticação da pagina -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- add bootstrap compilado -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <style>
           body { padding: 20px; }
           .navbar { margin-bottom: 20px; }
       </style>

    </head>
    <body>
      <div class="conteiner">
        @component('componente_navbar', ['current' => $current])
        @endcomponent
        <main role="main">
          @hasSection('body')
            @yield('body')
          @endif
        </main>
      </div>

      <!-- add javascript do bootstrap compilado -->
      <script src="{{asset('js/app.js')}}" charset="utf-8" type="text/javascript"> </script>

    </body>
</html>
