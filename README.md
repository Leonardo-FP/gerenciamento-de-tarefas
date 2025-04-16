# **Projeto Gerenciamento de Tarefas - Laravel + Docker**

Este é um projeto Laravel configurado para rodar com Docker. Abaixo estão as etapas para configurar e executar a aplicação no seu ambiente local.

## **Requisitos**

- Docker e Docker Compose instalados em sua máquina.

## **Execute os passos abaixo para rodar o projeto**

```bash
# Clone o repositório no endereço
https://github.com/Leonardo-FP/gerenciamento-de-tarefas

# Configuração do ambiente

## Copie o arquivo .env
cp .env.example .env

## Verifique no .env as configurações do banco de dados e altere conforme a configuração do seu Docker
DB_CONNECTION=mysql
DB_HOST=laravel-mysql
DB_PORT=3306
DB_DATABASE=gerenciamento_de_tarefas
DB_USERNAME=root
DB_PASSWORD=12345678

## Construa e rode os containers

docker-compose up --build -d

## Ajuste permissões de diretórios

docker exec -it laravel-php bash

chmod -R 775 storage
chown -R www-data:www-data storage
chmod -R 775 storage/framework

## Gerar a Key do Laravel
docker exec -it laravel-php php artisan key:generate

## Rodar as migrations
docker exec -it laravel-php php artisan migrate
