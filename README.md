# PAYMENT_APP
[![Linkedin Badge](https://img.shields.io/badge/-LinkedIn-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/fagnerpsantos/)](https://www.linkedin.com/in/alan-silva-torquato-75803878/)

Este projeto tem como intuito simular uma api de transferência entre contas, 
onde contas comuns podem fazer transferência entre elas e contas do tipo lojista(store) apenas podem receber transferências 

## Pré-requisito

Para executar o projeto, será necessário instalar os seguintes programas:

- [Docker](https://docs.docker.com/compose/install/)

- [Laravel](https://laravel.com/docs/8.x)

## Iniciando

### instalar as dependencias

```
    composer install
```
### copiar env de exemplo

```
    cp .env.example .env
```

## Testes

Para rodar os testes, utilize o comando abaixo:

```
docker-compose exec app vendor/bin/phpunit tests
```

## Documentação API

Para visualizar a documentação da API sera necessário acessar o link  a baixo:

- [DOC API](http://localhost:8080/api/documentation)
