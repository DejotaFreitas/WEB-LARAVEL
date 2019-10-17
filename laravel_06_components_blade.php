//=====================VIEW=================================
<!DOCTYPE html>
<html lang="pt">
    <head>

      <!-- add bootstrap compilado -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

    </head>
    <body>

      @component('components.card')
      @endcomponent

      <br><br>

      <!-- passando valor pro slot ou pelo parametros -->
      @component('components.botao',['texto1'=>'texto do texto1','texto2'=>'texto do texto2'])
          Texto do slot
      @endcomponent

      <br><br>

      <!-- inserindo conteudo no {{$slot}} do componente -->
      @component('components.botao')

        @slot('texto1')
          texto do texto1
        @endslot

        Texto do slot

        @slot('texto2')
          texto do texto2
        @endslot

      @endcomponent

      <!-- add javascript do bootstrap compilado -->
      <script src="{{asset('js/app.js')}}" charset="utf-8" type="text/javascript"></script>

    </body>
</html>

//===========================componente=botao=================================
<!-- salvo em resources\views\components\botao.blade.php -->

<button type="button" class="btn btn-secondary">
  {{$texto1}}
	{{$slot}}
  {{$texto2}}
</button>


//===========================componente=card=================================
<!-- salvo em resources\views\components\botao.card.php -->

<div class="card" style="width: 18rem;">
	<img class="card-img-top" src="https://i1.wp.com/emotioncard.com.br/wp-content/uploads/2019/05/paisagem36.jpg?fit=1600%2C900&ssl=1" alt="Imagem de capa do card">
	<div class="card-body">
		<h5 class="card-title">Título do card</h5>
		<p class="card-text">Um exemplo de texto rápido para construir o título do card e fazer preencher o conteúdo do card.</p>
		<a href="#" class="btn btn-primary">Visitar</a>
	</div>
</div>
