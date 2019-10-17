@echo off
echo Insira o nome do projeto "echo"
set /p input=""
IF [%input%]==[] (
	 Echo Criando projeto ....
    composer create-project --prefer-dist laravel/laravel projeto
 ) ELSE (
		Echo Criando projeto %input% ....
    composer create-project --prefer-dist laravel/laravel %input%
 )

Echo Pulse cualquier tecla para continuar
PAUSE >nul
