<?php

require_once __DIR__ . '/../bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

$app = new Silex\Application();
$app['debug'] = getenv('APP_DEV'); // Enable Debug
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->after(function (Request $request, \Symfony\Component\HttpFoundation\Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});

$app->get('/', function () use ($app) {
    return $app->redirect('/docs');
});


/**
 * @api {get} /fabricante Busca todos os Fabricantes
 * @apiName GetFabricante
 * @apiGroup    Fabricante
 * @apiSuccess {number} status 200
 * @apiSuccess {object[]} response Todos os Fabricantes.
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
 * @api {post} /fabricante Adiciona novo Fabricante
 * @apiName PostFabricante
 * @apiGroup Fabricante
 *
 * @apiParam {string} nome Nome do Fabricante
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados do Fabricante criado
 * @apiError {Boelan} status 0
 * @apiError {string} message Mensagem de Erro
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
 * @api {get} /fabricante/:id Busca Fabricante por ID
 * @apiName GetFabricanteById
 * @apiGroup Fabricante
 *
 * @apiParam {number} id ID Unico do Fabricante
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados do Fabricante
 * @apiError {Boelan} status 0
 * @apiError {string} message Mensagem de Erro
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
 * @api {put} /fabricante/:id Atualiza Fabricante por ID
 * @apiName PutFabricante
 * @apiGroup Fabricante
 *
 * @apiParam {number} id ID Unico do Fabricante
 * @apiParam {string} nome Nome do Fabricante
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados do Fabricante
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
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
 * @api {delete} /fabricante/:id Remove Fabricante por ID
 * @apiName DeleteFabricante
 * @apiGroup Fabricante
 *
 * @apiParam {number} id ID Unico do Fabricante
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} message Mensagem de Sucesso
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "status": 200,
 *      "message": "Fabricante Removido."
 *  }
 */
$app->delete('/fabricante/{id}', function ($id) use ($app, $em) {

    $fabricante = $em->createQuery('delete Fabricante f WHERE f.id = ?1');
    $fabricante->setParameter(1, $id);

    if ($fabricante->execute()) {
        return $app->json(['status' => 200, 'message' => 'Fabricante Removido.']);
    }

    return $app->json(['status' => 0, 'message' => 'Fabricante não existe.']);

})->convert('id', function ($id) {
    return (int)$id;
});

/**
 * @api {get} /produto Busca todos os Produtos
 * @apiName GetProduto
 * @apiGroup    Produto
 * @apiSuccess {number} status 200
 * @apiSuccess {object[]} response Todos os Produtos.
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
 * @api {post} /produto Adiciona novo Produto
 * @apiName PostProduto
 * @apiGroup Produto
 *
 * @apiParam {string} nome Nome do Produto
 * @apiParam {number} fabricante ID do Fabricante
 * @apiParam {string} garantia Período de Garantia
 * @apiParam {number} grade
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados do Produto criado
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
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
    if (!$fabricante) {
        return $app->json(['status' => 0, 'message' => 'Fabricante não encontrado']);
    }

    $filial = $em->getRepository(Filial::class)->find($request->get('estoque')['filial']);
    if (!$filial) {
        return $app->json(['status' => 0, 'message' => 'Filial não encontrada']);
    }

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
//    $estoque = new Estoque();
//    $estoque->setFilial($filial);
//    $estoque->setQuantidade($request->get('estoque')['quantidade']);
//    $estoque->setProduto($produto);
//    $em->persist($estoque);
    $em->flush();
    $em->clear();

//    $produto->setEstoque($estoque);

    if ($produto->getId()) {
        return $app->json(['status' => 200, 'response' => $produto->toArray()]);
    }

    return $app->json(['status' => 0, 'message' => 'Não foi possivel criar o Produto']);
});


/**
 * @api {get} /produto/:id Busca Produto por ID
 * @apiName GetProdutoById
 * @apiGroup    Produto
 *
 * @apiParam {number} id ID Unico do Produto
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object[]} response Todos os Produtos.
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

/**
 * @api {put} /produto/:id Atualiza Produto
 * @apiName PutProduto
 * @apiGroup Produto
 *
 * @apiParam {number} id ID Unico do Produto
 *
 * @apiParam {string} nome Nome do Produto
 * @apiParam {number} fabricante ID do Fabricante
 * @apiParam {string} garantia Período de Garantia
 * @apiParam {number} grade
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados do Produto atualizado
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
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
$app->put('/produto/{id}', function ($id, Request $request) use ($app, $em) {
    $produto = $em->getRepository(Produto::class)->find($id);

    if (!$produto) {
        return $app->json(['status' => 0, 'message' => 'Produto não encontrado.']);
    }

    $fabricante = $em->getRepository(Fabricante::class)->find($request->get('fabricante'));
    if (!$fabricante) {
        return $app->json(['status' => 0, 'message' => 'Fabricante não encontrado']);
    }

    $filial = $em->getRepository(Filial::class)->find($request->get('estoque')['filial']);
    if (!$filial) {
        return $app->json(['status' => 0, 'message' => 'Filial não encontrada']);
    }

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
//    $filialId = $filial->getId();
//    $produtoId = $produto->getId();

    // Atualiza Estoque
//    $estoque = $em->createQuery("SELECT e FROM \Estoque e WHERE e.filial = $filialId AND e.produto = $produtoId")->getOneOrNullResult();
//    if (!$estoque) {
//        $estoque = new Estoque();
//    }

//    $estoque->setFilial($filial);
//    $estoque->setQuantidade($request->get('estoque')['quantidade']);
//    $estoque->setProduto($produto);
//    $em->persist($estoque);

    $em->flush();
    $em->clear();

//    if ($estoque) {
//        $produto->setEstoque($estoque);
//    }

    if ($produto->getId()) {
        return $app->json(['status' => 200, 'response' => $produto->toArray()]);
    }

    return $app->json(['status' => 0, 'message' => 'Não foi possivel criar o Produto']);
})->convert('id', function ($id) {
    return (int)$id;
});

/**
 * @api {delete} /produto/:id Remove Produto por ID
 * @apiName DeleteProduto
 * @apiGroup Produto
 *
 * @apiParam {number} id ID Unico do Produto
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} message Mensagem de Sucesso
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "status": 200,
 *      "message": "Fabricante Removido."
 *  }
 */
$app->delete('/produto/{id}', function ($id) use ($app, $em) {

    $produto = $em->createQuery('delete Produto p WHERE p.id = ?1');
    $produto->setParameter(1, $id);

    if ($produto->execute()) {
        return $app->json(['status' => 200, 'message' => 'Produto Removido.']);
    }

    return $app->json(['status' => 0, 'message' => 'Produto não existe.']);

})->convert('id', function ($id) {
    return (int)$id;
});

/**
 * @api {get} /filial Busca todas as Filiais
 * @apiName GetFilial
 * @apiGroup    Filial
 * @apiSuccess {number} status 200
 * @apiSuccess {object[]} response Todas as Filiais
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "status": 200,
 *      "response": [
 *        {
 *          "id": 1,
 *          "nome": "Filial 1"
 *        },
 *        {
 *          "id": 2,
 *          "nome": "Filial 2"
 *        }
 *     ]
 *  }
 */
$app->get('/filial', function () use ($app, $em) {
    $filiais = $em->createQuery('SELECT f FROM \Filial f')->getArrayResult();
    return $app->json(['status' => 200, 'response' => $filiais]);
});

/**
 * @api {post} /filial Adiciona nova Filial
 * @apiName PostFilial
 * @apiGroup Filial
 *
 * @apiParam {string} nome Nome da Filial
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados da Filial criada
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "id": 1,
 *      "nome": "Filial 1"
 *  }
 */
$app->post('/filial', function (Request $request) use ($app, $em) {
    $filial = new Filial();
    $filial->setNome($request->get('nome'));

    //Validation
    $errors = $app['validator']->validate($filial);
    if (count($errors) > 0) {
        return $app->json(['status' => 0, 'message' => $errors[0]->getMessage()]);
    }

    // Persiste no banco de dados
    $em->persist($filial);
    $em->flush();
    $em->clear();

    if ($filial->getId()) {
        return $app->json(['status' => 200, 'response' => $filial->toArray()]);
    }

    return $app->json(['status' => 0, 'message' => 'Não foi possivel criar a Filial']);
});

/**
 * @api {put} /filial/:id Atualiza Filial por ID
 * @apiName PutFilial
 * @apiGroup Filial
 *
 * @apiParam {number} id ID Unico da Filial
 * @apiParam {string} nome Nome da Filial
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados da Filial
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "id": 1,
 *      "nome": "Filial 1"
 *  }
 */
$app->put('/filial/{id}', function ($id, Request $request) use ($app, $em) {
    $filial = $em->getRepository(Filial::class)->find($id);
    $filial->setNome($request->get('nome'));

    //Validation
    $errors = $app['validator']->validate($filial);

    if (count($errors) > 0) {
        return $app->json(['status' => 0, 'message' => $errors[0]->getMessage()]);
    }

    $em->persist($filial);
    $em->flush();
    $em->clear();

    if ($filial->getId()) {
        return $app->json(['status' => 200, 'response' => $filial->toArray()]);
    }

    return $app->json(['status' => 0, 'message' => 'Não foi possivel atualizar a Filial']);

})->convert('id', function ($id) {
    return (int)$id;
});


/**
 * @api {get} /filial/:id Busca Filial por ID
 * @apiName GetFilialById
 * @apiGroup Filial
 *
 * @apiParam {number} id ID Unico da Filial
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados da Filial
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *   HTTP/1.1 200 OK
 *  {
 *      "id": 1,
 *      "nome": "Filial 1"
 *  }
 */
$app->get('/filial/{id}', function ($id) use ($app, $em) {
    $filial = $em->find(Filial::class, $id);
    if ($filial) {
        return $app->json($filial->toArray());
    }

    return $app->json(['status' => 0, 'message' => 'Filial não existe']);

})->convert('id', function ($id) {
    return (int)$id;
});

/**
 * @api {delete} /filial/:id Remove Filial por ID
 * @apiName DeleteFilial
 * @apiGroup Filial
 *
 * @apiParam {number} id ID Unico da Filial
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} message Mensagem de Sucesso
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "status": 200,
 *      "message": "Filial Removida"
 *  }
 */
$app->delete('/filial/{id}', function ($id) use ($app, $em) {

    $filial = $em->createQuery('delete Filial f WHERE f.id = ?1');
    $filial->setParameter(1, $id);

    if ($filial->execute()) {
        return $app->json(['status' => 200, 'message' => 'Filial Removida']);
    }

    return $app->json(['status' => 0, 'message' => 'Filial não existe.']);

})->convert('id', function ($id) {
    return (int)$id;
});

/**
 * @api {get} /estoque/:produto_id Estoque em todas as Filiais
 * @apiName GetEstoqueByProduto
 * @apiGroup Produto
 *
 * @apiParam {number} produto_id ID do Produto
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados do Estoque
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 * {
 *      "status": 200,
 *      "response": [
 *       {
 *           "id": 2,
 *           "quantidade": 10,
 *           "filial": {
 *                "id": 1,
 *                "nome": "Filial 1"
 *           }
 *       },
 *       {
 *           "id": 2,
 *           "quantidade": 20,
 *           "filial": {
 *                "id": 2,
 *                "nome": "Filial 2"
 *           }
 *       },
 *    ]
 * }
 */
$app->get('/estoque/{produto_id}', function ($produto_id) use ($app, $em) {

    $estoque = $em->createQuery('SELECT e,f FROM Estoque e LEFT JOIN e.filial f WHERE e.produto = ?1');
    $estoque->setParameter(1, $produto_id);

    if ($estoque->execute()) {
        return $app->json(['status' => 200, 'response' => $estoque->getArrayResult()]);
    }

    return $app->json(['status' => 0, 'message' => 'Estoque não encontrado']);

});

/**
 * @api {get} /estoque/:produto_id/:filial_id Estoque por filial
 * @apiName GetEstoqueByFilial
 * @apiGroup Produto
 *
 * @apiParam {number} produto_id ID do Produto
 * @apiParam {number} filial_id ID da Filial
 *
 * @apiSuccess {number} status 200
 * @apiSuccess {object} response Dados do Estoque
 * @apiError {number} status 0
 * @apiError {string} message Mensagem de Erro
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 * {
 *      "status": 200,
 *      "response": [
 *       {
 *           "id": 2,
 *           "quantidade": 10,
 *           "filial": {
 *                "id": 1,
 *                "nome": "Filial 1"
 *           }
 *       }
 *    ]
 * }
 */
$app->get('/estoque/{produto_id}/{filial_id}', function ($produto_id, $filial_id) use ($app, $em) {
    $estoque = $em->createQueryBuilder()
        ->select('e,f')
        ->from('Estoque', 'e')
        ->where('e.produto = :produto_id AND e.filial = :filial_id')
        ->join('e.filial', 'f')
        ->setParameters(new \Doctrine\Common\Collections\ArrayCollection(array(
            new \Doctrine\ORM\Query\Parameter('produto_id', $produto_id),
            new \Doctrine\ORM\Query\Parameter('filial_id', $filial_id)
        )))->getQuery()->getArrayResult();

    if (isset($estoque)) {
        return $app->json(['status' => 200, 'response' => $estoque]);
    }
    return $app->json(['status' => 0, 'message' => 'Estoque não encontrado']);
});

$app->run();