# **Projeto Gerenciamento de Tarefas - Laravel + Docker**

Este é um projeto Laravel configurado para rodar com Docker. Abaixo estão as etapas para configurar e executar a aplicação no seu ambiente local.

## **Requisitos**

- Docker e Docker Compose instalados em sua máquina.

## **Execute os passos abaixo para rodar o projeto**

```bash
# Clone o repositório público presente no endereço
https://github.com/Leonardo-FP/gerenciamento-de-tarefas

# CONFIGURAÇÃO DO AMBIENTE

## Após clonar, entre no projeto
cd gerenciamento-de-tarefas/src

## Copie o arquivo .env
cp .env.example .env

## Verifique no .env as configurações do banco de dados e altere (caso necessário) conforme a configuração do seu Docker 
DB_CONNECTION=mysql
DB_HOST=laravel-mysql
DB_PORT=3306
DB_DATABASE=gerenciamento_de_tarefas
DB_USERNAME=root
DB_PASSWORD=root

## Construa e rode os containers
docker-compose up --build -d

## Acesse o container do PHP
docker exec -it laravel-php bash

## Instale as dependências do projeto
composer install

## Ajuste permissões de diretórios
chmod -R 775 storage && chown -R www-data:www-data storage && chmod -R 775 storage/framework

## Gere a Key do Laravel
php artisan key:generate

## Rode as migrations
php artisan migrate
