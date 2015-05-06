<?php

namespace FRD\Sistema\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class CategoriasController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        Request::enableHttpMethodParameterOverride();

        $categorias = $app['controllers_factory'];

        $categorias->get("/", function() use($app) {
            $dados = $app['CategoriaProdutoService']->findAll();

            return $app['twig']->render('categorias.twig',['categorias'=>$dados]);
        })->bind("categorias");

        $categorias->get("/{id}", function($id) use($app) {

            return $app['twig']->render('categoria.twig',['categoria'=>$app['CategoriaProdutoService']->find($id)]);

        })->bind("categoria");


        $categorias->post("/", function(Request $request) use($app) {
            $data['nome'] = $request->get('nome');

            $validator = $app['CategoriaProdutoService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                $dados = $app['CategoriaProdutoService']->findAll();
                return $app['twig']->render('categorias.twig',['categorias'=>$dados, 'errors'=>$validator->getLogErrors()]);
            }

            $result = $app['CategoriaProdutoService']->insert($data);
            $dados = $app['CategoriaProdutoService']->findAll();

            return $app['twig']->render('categorias.twig',['categorias'=>$dados, 'result'=>$result]);

        })->bind('cadastrar_categoria');


        $categorias->put("/{id}", function(Request $request, $id) use($app) {
            $data['nome'] = $request->get('nome');

            $validator = $app['CategoriaProdutoService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                $dados = $app['CategoriaProdutoService']->findAll();
                return $app['twig']->render('categorias.twig',['categorias'=>$dados, 'errors'=>$validator->getLogErrors()]);
            }

            $result = $app['CategoriaProdutoService']->update($id, $data);
            $dados = $app['CategoriaProdutoService']->findAll();

            return $app['twig']->render('categorias.twig',['categorias'=>$dados, 'result'=>$result]);

        })->bind('alterar_categoria');


        $categorias->delete("/{id}", function($id) use($app) {

            $result = $app['CategoriaProdutoService']->delete($id);
            $dados = $app['CategoriaProdutoService']->findAll();

            return $app['twig']->render('categorias.twig',['categorias'=>$dados, 'result'=>$result]);

        })->bind("apagar_categoria");


        return $categorias;
    }

}