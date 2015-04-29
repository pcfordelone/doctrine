<?php

namespace FRD\Sistema\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ApiCategoriaProdutosController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        Request::enableHttpMethodParameterOverride();

        $api_categoria_produtos = $app['controllers_factory'];

        $api_categoria_produtos->get("/", function() use($app) {
            $data = $app['CategoriaProdutoService']->findAll();

            return $app->json($data);
        });


        $api_categoria_produtos->get("/{id}", function($id) use($app) {
            $data = $app['CategoriaProdutoService']->find($id);

            return $app->json($data[0]);
        });


        $api_categoria_produtos->post("/", function(Request $request) use($app) {
            $data['nome'] = $request->get('nome');

            $app['CategoriaProdutoService']->insert($data);
            return $app->json($data);
        });

        return $api_categoria_produtos;
    }

} 