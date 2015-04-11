<?php

namespace FRD\Sistema;

use Doctrine\ORM\EntityManager;
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

            $produtoService = new ProdutoService($em);

            return $produtoService;
        };

        $app->mount("/", new IndexController());
        $app->mount("/produtos", new ProdutosController());
        $app->mount("/api/produtos", new ApiProdutosController());
    }

} 