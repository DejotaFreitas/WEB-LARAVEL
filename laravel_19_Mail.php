<?php
//==================CONFIGURACOES====================================
//configrando .env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=ENTER_YOUR_EMAIL_ADDRESS(GMAIL)
MAIL_PASSWORD=ENTER_YOUR_GMAIL_PASSWORD
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=ENTER_YOUR_EMAIL_ADDRESS(GMAIL)
MAIL_FROM_NAME="TITULO EMAIL COM ESPAÇOS"

// EXEMPOLO:
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=sysscreensoftware@gmail.com
MAIL_PASSWORD=0123
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=sysscreensoftware@gmail.com
MAIL_FROM_NAME="SysScreen Software"

//Aplicar configurações do .env
php artisan cache:clear && php artisan config:clear && php artisan config:cache

// DEPOIS
- MAIL_USERNAME e PASSWORD devem ser substituídos pelo seu endereço de e-mail e senha do Gmail, respectivamente. Faça login na sua Conta do Google, acesse Configurações de segurança e ATIVE O BOTÃO DE ALTERNÂNCIA PERMITIR APLICATIVOS MENOS SEGUROS.


//===================COMANDOS==========================================
// criar email em: app\Mail\NomeMail.php
php artisan make:mail NomeMail

//==================MAIL=CLASS=====================================

class EnviarEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $nome;
    public function __construct($nome) {
        $this->nome = $nome;
    }


    public function build() {
        return $this->view('emails.emailtext')
          ->from('noreply@domain.com', 'Nome do Remetente')
          ->subject('Assunto do Emial')
          ->with(['nome' => $this->nome]);
          // ->attach(base_path().'/public/arquivos/arquivo.pdf');
          // <img src="{{ $message->embed(public_path().'/img/logo.png') }}">

    }
}


//=================EMAIL=LAYOUT=HTML=========================================
// \resources\views\emails\emailtext.blade.php

<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Bem vindo {{$nome}}, você conseguiu enviar email!!!</h1>
	</body>
</html>



//===================ENVIAR=MAIL=POR=ROUTE==============================
Route::get('/enviaremail', function () {

  Illuminate\Support\Facades\Mail::to("djxpgs@gmail.com")
						->send(new App\Mail\EnviarEmail("DEJOTA"));

    return view('welcome');
});





//=====================================================================



//=====================================================================
