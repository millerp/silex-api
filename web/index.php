<?php

require_once __DIR__ . '/../bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

$app = new Silex\Application();
$app['debug'] = true; // Enable Debug
$app->register(new Silex\Provider\ValidatorServiceProvider());

$qb = $em->createQueryBuilder();

$app->get('/', function () use ($app) {
    return $app->redirect('/docs');
});


/**
 * @api {GET} /fabricante Busca todos os Fabricantes
 * @apiName GetFabricante
 * @apiGroup    Fabricante
 * @apiSuccess {Bolean} status 200
 * @apiSuccess {Object[]} response Todos os Fabricantes.
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
 * @api {GET} /fabricante/:id Busca Fabricante por id
 * @apiName PostFabricante
 * @apiGroup Fabricante
 *
 * @apiParam {Number} id ID Unico do Fabricante
 *
 * @apiSuccess {Bolean} status 200
 * @apiSuccess {Object} response Dados do Fabricante
 * @apiError {Boelan} status 0
 * @apiError {String} message Mensagem de Erro
 */
$app->get('/fabricante/{id}', function ($id) use ($app, $em) {
    $fabricante = $em->find(Fabricante::class, $id);
    if ($fabricante) {
        return $app->json($fabricante->toArray());
    } else {
        return $app->json(['status' => 0, 'message' => 'Fabricante não existe']);
    }
})->convert('id', function ($id) {
    return (int)$id;
});

/**
 * @api {PUT} /fabricante/:id Atualiza Fabricante por id
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
 * @api {DELETE} /fabricante/:id Remove Fabricante por id
 * @apiName DeleteFabricante
 * @apiGroup Fabricante
 *
 * @apiParam {Number} id ID Unico do Fabricante
 *
 * @apiSuccess {Bolean} status 200
 * @apiSuccess {Object} message Mensagem de Sucesso
 * @apiError {Boelan} status 0
 * @apiError {String} message Mensagem de Erro
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
    return $app->json($produtos);
});


$app->run();