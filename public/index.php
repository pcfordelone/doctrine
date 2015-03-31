<?php

require_once __DIR__.'/../bootstrap.php';

$app['dbConn'] = function() {
    $pdo = new PDO("mysql:host=localhost;dbname=code_silex","root","root",array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    return $pdo;
};

$app['clienteService'] = function() use($app) {
    $cliente = new \FRD\Sistema\Entity\Cliente();
    $mapper = new \FRD\Sistema\Mapper\ClienteMapper($app['dbConn']);

    $clienteService = new \FRD\Sistema\Service\ClienteService($cliente, $mapper);

    return $clienteService;
};

$app['ProdutoService'] = function() use($app) {
    $produto = new \FRD\Sistema\Entity\Produto();
    $produtoMapper = new \FRD\Sistema\Mapper\ProdutoMapper($app['dbConn']);

    $produtoService = new \FRD\Sistema\Service\ProdutoService($produto, $produtoMapper);

    return $produtoService;
};

$app->get("/", function() use($app) {
    return $app['twig']->render('index.twig',[]);
})->bind('index');


$app->get("/ola/{nome}", function($nome) use($app) {
    return $app['twig']->render('ola.twig',['nome'=>$nome]);
});


$app->get("/clientes", function() use($app) {
    $dados = $app['clienteService']->fetchAll();
    return $app['twig']->render('clientes.twig',['clientes'=>$dados]);
})->bind("clientes");

$app->post("/clientes", function() use($app) {
    $dados['nome'] = $_POST['nome'];
    $dados['email'] = $_POST['email'];
    $dados['cpfCnpj'] = $_POST['cpfCnpj'];

    $result = $app['clienteService']->insert($dados);
    return $result;
});

$app->get("clientes/{id}", function($id) use($app) {
    $result = $app['clienteService']->find($id);

    return $app['twig']->render('cliente.twig',['cliente'=>$result]);
});


$app->get("/cliente", function() use($app) {
    $dados['nome'] = 'Cliente A';
    $dados['email'] = 'clientea@gmail.com';
    $dados['cpfCnpj'] = '444.222.333-22';

    $result = $app['clienteService']->insert($dados);

    return $app->json($result);
});

$app->get("/produtos", function() use($app) {
    $dados = $app['ProdutoService']->fetchAll();

    return $app['twig']->render('produtos.twig',['produtos'=>$dados]);
});

$app->run();