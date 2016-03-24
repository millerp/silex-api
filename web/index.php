<?php

require_once __DIR__ . '/../bootstrap.php';

$app = new Silex\Application();

$app['debug'] = true; // Enable Debug

$app->get('/fabricante', function () use ($app, $entityManager) {
    $fabricantes = $entityManager->createQuery('SELECT f FROM \Fabricante f')->getArrayResult();
    return $app->json($fabricantes);
});

$app->post('/fabricante', function () use ($app) {
    return $app->json(['method' => 'post', 'message' => 'cria fabricante']);
});

$app->get('/fabricante/{id}', function ($id) use ($app) {
    return $app->json(['method' => 'get', 'message' => 'fabricante ' . $id]);
});

$app->get('/produto', function () use ($app, $entityManager) {
    $produtos = $entityManager->createQuery('SELECT p, f, e, l FROM \Produto p JOIN p.fabricante f JOIN p.estoque e JOIN e.filial l')->getArrayResult();
    return $app->json($produtos);
});


$app->run();