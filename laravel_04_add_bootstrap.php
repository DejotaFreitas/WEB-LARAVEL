//===================INSTALANDO=BOOTSTRAP=================================

// instalando andaimes com bootstrap e vue, react
composer require laravel/ui --dev

// Gerar andaimes básicos
php artisan ui vue
php artisan ui react

//OU

// Gerar andaimes de login / registro ...
php artisan ui vue --auth
php artisan ui react --auth

//apos gerar deve instalar as dependencias
npm install

// se nao for ultilizar o VUE ou REACT
// VA EM: \resources\js\app.js e comente o codigo corespondente ao VUE ou REACT
// depois compila
npm run dev

// compilar dependencias para poder usar o bootstrap e vue ou react no projeto
npm run dev

//=====================VIEW=================================
<!DOCTYPE html>
<html lang="pt">
    <head>

      <!-- token de autenticação da pagina -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <!-- add bootstrap compilado -->
      <link rel="stylesheet" href="{{asset('css/app.css')}}">

    </head>
    <body>

      <!-- // codigo html.... -->

      <!-- add javascript do bootstrap compilado -->
      <script src="{{asset('js/app.js')}}" charset="utf-8" type="text/javascript"></script>

    </body>
</html>
