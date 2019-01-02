# API NOTÍCIAS

Api de Notícias

O projeto usa Swagger como documentador da api. Versão de demonstração disponível em: http://5.189.187.150/noticias/public

Arquivos criados importantes do projeto:
- Controllers
--   app/Http/Controllers/NewsController.php
- Models
-- app/News.php
- Tests
-- tests/Unit/Http/Controllers/NewsControllerTest.php
-- tests/Unit/NewsTest.php
- Migrations
-- 2018_12_29_064215_create_news_table.php
- Database Model
-- database/noticias.mwb


# Instalação
1. Para instalar as dependencias, na raiz do projeto digitar
```sh
composer install
```
2. Para criar um banco de dados chamado noticias com o mysql, fazer login no mysql e rodar o comando
```sh
create database noticias;
```
3. configurar os dados de acesso no arquivo .env (renomear o arquivo .env.example para .env)
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nomedobanco
DB_USERNAME=usuario
DB_PASSWORD=senha
```
4. Para que sejam instaladas as tabelas, rodar o comando:
```sh
php artisan migrate
```
4. Para gerar as chaves do projeto, digitar o comando:
```sh
php artisan key:generate
```
5. Redirecionando o swagger para seu servidor: no arquivo public/json/swagger.json alterar o valor de host para o endereço do seu servidor

# ENDPOINTS
Existem dois endpoints no projeto

1. Endpoit "api/news" para recuperar todas as notícias paginadas. Exemplo:
http://5.189.187.150/noticias/public/api/news?page=2
5. Endpoint "api/news/{id}" para obter cada notícia conforme o id passado. Exemplo: http://5.189.187.150/noticias/public/api/news/40