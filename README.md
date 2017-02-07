[![Stories in Ready](https://badge.waffle.io/millerp/silex-api.png?label=ready&title=Ready)](https://waffle.io/millerp/silex-api)
# API de Consulta de produtos

API que permita consultar e atualizar o estoque de produtos.

## Entidades
* Fabricante
  * Id
  * Nome
* Filial
  * Id
  * Nome
* Produto
  * Id
  * Nome
  * _Fabricante_
  * Período de Garantia
  * Grade
  * Estoques por Filial
    * _Filial_
    * Quantidade


## Endpoints

* GET /produtos
* GET /produtos/{:id}

* GET /fabricantes

@todo Terminar de listar endpoints

## Documentação
http://swagger.io/

## Livro
https://pages.apigee.com/rs/apigee/images/api-design-ebook-2012-03.pdf

## Resultado esperado
* API REST seguindo padrão RESTFUL;
* Código implementado em PHP;
* _Utilização de microframework Silex_;
* _Utilização de doctrine orm_;
* Documentação da API;
