<?php

namespace FRD\Sistema\Controllers;

use Doctrine\ORM\AbstractQuery;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ApiProdutosController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        Request::enableHttpMethodParameterOverride();

        $api_produto = $app['controllers_factory'];

        $api_produto->get("/", function() use($app) {
            $data = $app['ApiProdutoService']->findAll();

            return $app->json($data);
        });


        $api_produto->get("/{id}", function($id) use($app) {
            $data = $app['ApiProdutoService']->find($id);

            return $app->json($data[0]);
        });


        $api_produto->post("/", function(Request $request) use($app) {
            $data['nome'] = $request->get('nome');
            $data['valor'] = floatval($request->get('valor'));
            $data['descricao'] = $request->get('descricao');
            $data['categoria'] = intval($request->get('categoria'));
            $data['tags'] = $request->get('tags');

            $validator = $app['ApiProdutoService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                $dados = $app['ApiProdutoService']->findAll();
                return $app['twig']->render('produtos.twig',['produtos'=>$dados, 'errors'=>$validator->getLogErrors()]);
            }

            $app['ApiProdutoService']->insert($data);
            return $app->json($data);
        });

        $api_produto->put("/{id}", function(Request $request, $id) use($app) {
            $data['nome'] = $request->get('nome');
            $data['categoria'] = $request->get('categoria');
            $data['descricao'] = $request->get('descricao');
            $data['valor'] = floatval($request->get('valor'));
            $data['tags'] = $request->get('tags');

            $validator = $app['ApiProdutoService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                return "erro";
            }

            $app['ApiProdutoService']->update($id, $data);

            return $app->json($data);
        });

        $api_produto->delete("/{id}", function($id) use($app) {
            $app['ApiProdutoService']->delete($id);
            return $app->json(true);
        });

        return $api_produto;
    }
} 