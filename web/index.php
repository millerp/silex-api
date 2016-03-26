<?php

require_once __DIR__ . '/../bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

$app = new Silex\Application();
$app['debug'] = true; // Enable Debug
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->get('/', function () use ($app) {
    return $app->redirect('/docs');
});


/**
 * @api {GET} /fabricante Busca todos os Fabricantes
 * @apiName GetFabricante
 * @apiGroup    Fabricante
 * @apiSuccess {Bolean} status 200
 * @apiSuccess {Object[]} response Todos os Fabricantes.
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "status": 200,
 *      "response": [
 *        {
 *          "id": 3,
 *          "nome": "Fabricante 1"
 *        },
 *        {
 *          "id": 4,
 *          "nome": "Fabricante 2"
 *        }
 *     ]
 *  }
 */
$app->get('/fabricante', function () use ($app, $em) {
    $fabricantes = $em->createQuery('SELECT f FROM \Fabricante f')->getArrayResult();
    return $app->json(['status' => 200, 'response' => $fabricantes]);
});

/**
 * @api {POST} /fabricante Adiciona novo Fabricante
 * @apiName PostFabricante
 * @apiGroup Fabricante
 *
 * @apiParam {String} bome Nome do Fabricante
 *
 * @apiSuccess {Bolean} status 200
 * @apiSuccess {Object} response Dados do Fabricante criado
 * @apiError {Boelan} status 0
 * @apiError {String} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "id": 1,
 *      "nome": "Fabricante 1"
 *  }
 */
$app->post('/fabricante', function (Request $request) use ($app, $em) {
    $fabricante = new Fabricante();
    $fabricante->setNome($request->get('nome'));

    //Validation
    $errors = $app['validator']->validate($fabricante);
    if (count($errors) > 0) {
        return $app->json(['status' => 0, 'message' => $errors[0]->getMessage()]);
    }

    // Persiste no banco de dados
    $em->persist($fabricante);
    $em->flush();
    $em->clear();

    if ($fabricante->getId()) {
        return $app->json(['status' => 200, 'response' => $fabricante->toArray()]);
    }

    return $app->json(['status' => 0, 'message' => 'Não foi possivel criar o Fabricante']);
});

/**
 * @api {GET} /fabricante/:id Busca Fabricante por ID
 * @apiName GetFabricanteById
 * @apiGroup Fabricante
 *
 * @apiParam {Number} id ID Unico do Fabricante
 *
 * @apiSuccess {Bolean} status 200
 * @apiSuccess {Object} response Dados do Fabricante
 * @apiError {Boelan} status 0
 * @apiError {String} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *   HTTP/1.1 200 OK
 *  {
 *      "id": 1,
 *      "nome": "Fabricante 1"
 *  }
 */
$app->get('/fabricante/{id}', function ($id) use ($app, $em) {
    $fabricante = $em->find(Fabricante::class, $id);
    if ($fabricante) {
        return $app->json($fabricante->toArray());
    }

    return $app->json(['status' => 0, 'message' => 'Fabricante não existe']);

})->convert('id', function ($id) {
    return (int)$id;
});

/**
 * @api {PUT} /fabricante/:id Atualiza Fabricante por ID
 * @apiName PutFabricante
 * @apiGroup Fabricante
 *
 * @apiParam {Number} id ID Unico do Fabricante
 * @apiParam {String} nome Nome do Fabricante
 *
 * @apiSuccess {Bolean} status 200
 * @apiSuccess {Object} response Dados do Fabricante
 * @apiError {Boelan} status 0
 * @apiError {String} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "id": 1,
 *      "nome": "Fabricante 1"
 *  }
 */
$app->put('/fabricante/{id}', function ($id, Request $request) use ($app, $em) {
    $fabricante = $em->getRepository(Fabricante::class)->find($id);
    $fabricante->setNome($request->get('nome'));

    //Validation
    $errors = $app['validator']->validate($fabricante);

    if (count($errors) > 0) {
        return $app->json(['status' => 0, 'message' => $errors[0]->getMessage()]);
    }

    $em->persist($fabricante);
    $em->flush();
    $em->clear();

    if ($fabricante->getId()) {
        return $app->json(['status' => 200, 'response' => $fabricante->toArray()]);
    }

    return $app->json(['status' => 0, 'message' => 'Não foi possivel atualizar o Fabricante.']);

})->convert('id', function ($id) {
    return (int)$id;
});

/**
 * @api {DELETE} /fabricante/:id Remove Fabricante por ID
 * @apiName DeleteFabricante
 * @apiGroup Fabricante
 *
 * @apiParam {Number} id ID Unico do Fabricante
 *
 * @apiSuccess {Bolean} status 200
 * @apiSuccess {Object} message Mensagem de Sucesso
 * @apiError {Boelan} status 0
 * @apiError {String} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "status": 200,
 *      "message": "Fabricante Removido."
 *  }
 */
$app->delete('/fabricante/{id}', function ($id) use ($app, $em) {

    $fabricante = $em->createQuery('DELETE Fabricante f WHERE f.id = ?1');
    $fabricante->setParameter(1, $id);

    if ($fabricante->execute()) {
        return $app->json(['status' => 200, 'message' => 'Fabricante Removido.']);
    }

    return $app->json(['status' => 0, 'message' => 'Fabricante não existe.']);

})->convert('id', function ($id) {
    return (int)$id;
});

/**
 * @api {GET} /produto Busca todos os Produtos
 * @apiName GetProduto
 * @apiGroup    Produto
 * @apiSuccess {Bolean} status 200
 * @apiSuccess {Object[]} response Todos os Produtos.
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *      {
 *          "id": 5,
 *          "nome": "Produto 1",
 *          "garantia": "6 meses",
 *          "grade": "0",
 *          "fabricante": {
 *              "id": 3,
 *              "nome": "Fabricante 1"
 *          },
 *          "estoque": [
 *          {
 *              "id": 1,
 *              "quantidade": 51,
 *              "filial": {
 *                  "id": 1,
 *                  "nome": "Filial 1"
 *              }
 *          },
 *          {
 *              "id": 5,
 *              "quantidade": 10,
 *              "filial": {
 *                  "id": 2,
 *                  "nome": "Filial 2"
 *              }
 *           }
 *         ]
 *     }
 */
$app->get('/produto', function () use ($app, $em) {
    $dql = "SELECT p, f, e, l FROM \Produto p JOIN p.fabricante f JOIN p.estoque e JOIN e.filial l";
    $produtos = $em->createQuery($dql)->getArrayResult();
    return $app->json(['status' => 200, 'response' => $produtos]);
});

/**
 * @api {POST} /produto Adiciona novo Produto
 * @apiName PostProduto
 * @apiGroup Produto
 *
 * @apiParam {String} nome Nome do Produto
 * @apiParam {Number} fabricante ID do Fabricante
 * @apiParam {String} garantia Período de Garantia
 * @apiParam {Number} grade
 * @apiParam {Object} estoque Estoque por Filial
 * @apiParam {Number} estoque.filial ID da Filial
 * @apiParam {Number} estoque.quantidade Quantidade de Produtos em Estoque
 *
 * @apiSuccess {Number} status 200
 * @apiSuccess {Object} response Dados do Produto criado
 * @apiError {Number} status 0
 * @apiError {String} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *      {
 *          "id": 1,
 *          "nome": "Produto 1",
 *          "garantia": "6 meses",
 *          "grade": "0",
 *          "fabricante": {
 *              "id": 1,
 *              "nome": "Fabricante 1"
 *          },
 *          "estoque": [
 *          {
 *              "id": 1,
 *              "quantidade": 10,
 *              "filial": {
 *                  "id": 1,
 *                  "nome": "Filial 1"
 *              }
 *          }
 *         ]
 *     }
 */
$app->post('/produto', function (Request $request) use ($app, $em) {

    $fabricante = $em->getRepository(Fabricante::class)->find($request->get('fabricante'));
    $filial = $em->getRepository(Filial::class)->find($request->get('estoque')['filial']);

    $produto = new Produto();
    $produto->setNome($request->get('nome'));
    $produto->setFabricante($fabricante);
    $produto->setGarantia($request->get('garantia'));
    $produto->setGrade($request->get('grade'));

    //Validation
    $errors = $app['validator']->validate($produto);
    if (count($errors) > 0) {
        return $app->json(['status' => 0, 'message' => $errors[0]->getMessage()]);
    }

    // Persiste no banco de dados
    $em->persist($produto);

    // Adiciona Estoque
    $estoque = new Estoque();
    $estoque->setFilial($filial);
    $estoque->setQuantidade($request->get('estoque')['quantidade']);
    $estoque->setProduto($produto);
    $em->persist($estoque);
    $em->flush();
    $em->clear();

    $produto->setEstoque($estoque);

    if ($produto->getId()) {
        return $app->json(['status' => 200, 'response' => $produto->toArray()]);
    }

    return $app->json(['status' => 0, 'message' => 'Não foi possivel criar o Produto']);
});


/**
 * @api {GET} /produto/:id Busca Produto por ID
 * @apiName GetProdutoById
 * @apiGroup    Produto
 * @apiSuccess {Number} status 200
 * @apiSuccess {Object[]} response Todos os Produtos.
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *      {
 *          "id": 5,
 *          "nome": "Produto 1",
 *          "garantia": "6 meses",
 *          "grade": "0",
 *          "fabricante": {
 *              "id": 3,
 *              "nome": "Fabricante 1"
 *          },
 *          "estoque": [
 *          {
 *              "id": 1,
 *              "quantidade": 51,
 *              "filial": {
 *                  "id": 1,
 *                  "nome": "Filial 1"
 *              }
 *          },
 *          {
 *              "id": 5,
 *              "quantidade": 10,
 *              "filial": {
 *                  "id": 2,
 *                  "nome": "Filial 2"
 *              }
 *           }
 *         ]
 *     }
 */
$app->get('/produto/{id}', function ($id) use ($app, $em) {
    $dql = "SELECT p, f, e, l FROM \Produto p JOIN p.fabricante f JOIN p.estoque e JOIN e.filial l WHERE p.id = $id";
    $produto = $em->createQuery($dql)->getArrayResult();
    if ($produto) {
        return $app->json(['status' => 200, 'response' => $produto]);
    }
    return $app->json(['status' => 0, 'message' => 'Produto não existe']);
})->convert('id', function ($id) {
    return (int)$id;
});


$app->run();