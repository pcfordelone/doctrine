<?php

namespace FRD\Sistema;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use FRD\Sistema\Entity\Produto;
use FRD\Sistema\Mapper\ProdutoMapper;
use FRD\Sistema\Service\ProdutoService;
use FRD\Sistema\Controllers\IndexController;
use FRD\Sistema\Controllers\ProdutosController;
use FRD\Sistema\Controllers\ApiProdutosController;

class App extends Application
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);
        $app = $this;

        $app->register(new TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/views',
        ));

        $app->register(new UrlGeneratorServiceProvider());
        $app->register(new ValidatorServiceProvider());

        $app['dbConn'] = $app->share(function() {
            try {
                $pdo = new \PDO("mysql:host=localhost;dbname=code_silex","root","root",array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            catch (\PDOException $e) {
                die("Não foi possível estabelecer uma conexão com o banco de dados.<br>Código do Erro: ".$e->getCode()."<br> Mensagem: ".$e->getMessage());
            }
            return $pdo;
        });

        $app['ProdutoService'] = function() use($app) {
            $produto = new Produto();
            $produtoMapper = new ProdutoMapper($app['dbConn']);

            $produtoService = new ProdutoService($produto, $produtoMapper);

            return $produtoService;
        };

        $app->mount("/", new IndexController());
        $app->mount("/produtos", new ProdutosController());
        $app->mount("/api/produtos", new ApiProdutosController());
    }

} 