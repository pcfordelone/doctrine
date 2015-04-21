<?php

namespace FRD\Sistema\Controllers;

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
            $data = $app['ProdutoService']->findAll();

            return $app->json($data);
        });


        $api_produto->get("/{id}", function($id) use($app) {
            $data = $app['ProdutoService']->find($id);

            return $app->json($data[0]);
        });


        $api_produto->post("/", function(Request $request) use($app) {
            $data['nome'] = $request->get('nome');
            $data['valor'] = floatval($request->get('valor'));
            $data['descricao'] = $request->get('descricao');

            $validator = $app['ProdutoService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                $dados = $app['ProdutoService']->findAll();
                return $app['twig']->render('produtos.twig',['produtos'=>$dados, 'errors'=>$validator->getLogErrors()]);
            }

            $app['ProdutoService']->insert($data);
            return $app->json($data);
        });

        $api_produto->put("/{id}", function(Request $request, $id) use($app) {
            $data['nome'] = $request->get('nome');
            $data['valor'] = $request->get('valor');
            $data['descricao'] = $request->get('descricao');

            $validator = $app['ProdutoService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                $dados = $app['ProdutoService']->findAll();
                return $app['twig']->render('produtos.twig',['produtos'=>$dados, 'errors'=>$validator->getLogErrors()]);
            }

            $app['ProdutoService']->update($id, $data);
            return $app->json($data);
        });

        $api_produto->delete("/{id}", function($id) use($app) {
            $app['ProdutoService']->delete($id);
            return $app->json(true);
        });

        return $api_produto;
    }

} 