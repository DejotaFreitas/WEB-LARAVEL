@echo off

SET /P _nome_projeto=Insira o nome do projeto: || SET _nome_projeto=projeto
echo Projeto: %_nome_projeto%

CD %_nome_projeto%
ECHO "%CD%"


:menu
	ECHO "========================================"
	ECHO  "0 - Criar Projeto"
	ECHO  "1 - Migrate Fresh"
	ECHO  "2 - Seeder"
	ECHO  "3 - Criar Model"
	ECHO  "4 - Criar Controle"
	ECHO  "5 - Criar do Migrate"
	ECHO  "6 - Criar Login Automatico"
	ECHO  "Qualquer outra tecla - Sair"
	
	SET _opicao=Insira = ""
	SET /P _opicao=Insira o numero da opicao desejada:

	IF [%_opicao%]==[0] (
		ECHO "Criar Projeto ...."
		composer create-project --prefer-dist laravel/laravel %_nome_projeto% 
		CD %_nome_projeto% 
		ECHO "%CD%"		


	) ELSE IF [%_opicao%]==[1] (
		 ECHO "Migrate Fresh ...."
		 php artisan migrate:fresh


	) ELSE IF [%_opicao%]==[2] (
		 ECHO "Seeder ...."
		 composer dump-autoload && php artisan db:seed


	) ELSE IF [%_opicao%]==[3] (
		 ECHO "Criar Model ...."
		SET /p input="Nome do Modelo: "
		IF NOT [%input%]==[] (
			ECHO Criando Modelo %input% ....
			php artisan make:model %input% --migration
		) ELSE (
			ECHO %input%
		)


	) ELSE IF [%_opicao%]==[4] (
		ECHO "Criar do Controle ...."
		SET /p input="Nome do Controle: "
		IF NOT [%input%]==[] (
			ECHO Criando Controle %input% ....
			php artisan make:controller %input% --resource
		) ELSE (
			ECHO %input%
		)


	) ELSE IF [%_opicao%]==[5] (
		 ECHO "Criar do Migrate ...."
		 SET /p input="Nome da Migrate: "
		 IF NOT [%input%]==[] (
			 ECHO Criando Migrate %input% ....
			 php artisan make:migration criar_tabela_%input% --table=%input%
		 ) ELSE (
			 ECHO %input%
		 )

	) ELSE IF [%_opicao%]==[6] (
		 ECHO "Criar Login Automatico ...."
		 composer require laravel/ui --dev
		 php artisan ui vue --auth
		 npm install && npm run dev


	) ELSE (
		GOTO sair
	)


	GOTO menu
GOTO :eof



:sair
	ECHO "Pressione qualquer tecla para sair..."
	PAUSE > nul
GOTO :eof
