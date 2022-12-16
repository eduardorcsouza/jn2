# Teste api cadastro de cliente

>Essa api foi escrita com framework laravel com php 8.1

## Instalação
Para instalar basta dar docker-compose up que a instalação ja vai subir e rodar o docker-composer

## Database
Para usar o database verifique o config, para o windows com wsl eu usei host.docker.internal

### Migrations
Para rodar as migrations e criar as tabelas basta entrar no docker
> docker exec -it eduardo-jn2-php "/bin/bash"

Após rodar o command

> php artisan migrate
