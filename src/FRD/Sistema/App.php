<?php

namespace FRD\Sistema;

use Doctrine\ORM\EntityManager;
use FRD\Sistema\Controllers\ApiCategoriaProdutosController;
use FRD\Sistema\Controllers\ApiTagController;
use FRD\Sistema\Controllers\CategoriasController;
use FRD\Sistema\Controllers\TagsController;
use FRD\Sistema\Logger\Logger;
use FRD\Sistema\Service\ApiCategoriaProdutoService;
use FRD\Sistema\Service\ApiProdutoService;
use FRD\Sistema\Service\CategoriaProdutoService;
use FRD\Sistema\Service\TagsService;
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
    public function __construct(array $values = array(), $em)
    {
        parent::__construct($values);
        $app = $this;

        $app->register(new TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/views',
        ));

        $app->register(new UrlGeneratorServiceProvider());
        $app->register(new ValidatorServiceProvider());

        $app['ProdutoService'] = function() use($em) {

            $logger = new Logger();
            $produtoService = new ProdutoService($em, $logger);

            return $produtoService;
        };

        $app['ApiProdutoService'] = function() use($em) {

            $logger = new Logger();
            $apiProdutoService = new ApiProdutoService($em, $logger);

            return $apiProdutoService;
        };

        $app['CategoriaProdutoService'] = function() use($em) {

            $logger = new Logger();
            $categoriaProdutoService = new CategoriaProdutoService($em, $logger);

            return $categoriaProdutoService;
        };

        $app['ApiCategoriaProdutoService'] = function() use($em) {

            $logger = new Logger();
            $api = new ApiCategoriaProdutoService($em, $logger);

            return $api;
        };

        $app['TagsService'] = function() use($em) {

            $logger = new Logger();
            $tagsService = new TagsService($em, $logger);

            return $tagsService;
        };

        $app['ProdutosData'] = function() {
            $data['produtos'] = $this['ProdutoService']->findAll();
            $data['categorias'] = $this['CategoriaProdutoService']->findAll();
            $data['tags'] = $this['TagsService']->findAll();

            return $data;
        };

        $app->mount("/", new IndexController());
        $app->mount("/produtos", new ProdutosController());
        $app->mount("/categorias", new CategoriasController());
        $app->mount("/tags", new TagsController());
        $app->mount("/api/produtos", new ApiProdutosController());
        $app->mount("/api/categorias", new ApiCategoriaProdutosController());
        $app->mount("/api/tags", new ApiTagController());
    }

} 