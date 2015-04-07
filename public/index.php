<?php

require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\Validator\Constraints as Assert;

$app['dbConn'] = $app->share(function() {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=code_silex","root","root",array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    catch (\PDOException $e) {
        die("Não foi possível estabelecer uma conexão com o banco de dados.<br>Código do Erro: ".$e->getCode()."<br> Mensagem: ".$e->getMessage());
    }
    return $pdo;
});

$app['ProdutoService'] = function() use($app) {
    $produto = new \FRD\Sistema\Entity\Produto();
    $produtoMapper = new \FRD\Sistema\Mapper\ProdutoMapper($app['dbConn']);

    $produtoService = new \FRD\Sistema\Service\ProdutoService($produto, $produtoMapper);

    return $produtoService;
};

$app->mount("/", include __DIR__.'/../controllers/index.php');
$app->mount("/produtos", include __DIR__.'/../controllers/produtos.php');
$app->mount("/api/produtos", include __DIR__.'/../controllers/api-produtos.php');

$app->run();