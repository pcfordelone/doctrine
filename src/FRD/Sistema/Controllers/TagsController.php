<?php

namespace FRD\Sistema\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class TagsController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        Request::enableHttpMethodParameterOverride();

        $tags = $app['controllers_factory'];

        $tags->get("/", function() use($app) {
            $dados = $app['TagsService']->findAll();

            return $app['twig']->render('tags.twig',['tags'=>$dados]);
        })->bind("tags");

        $tags->get("/{id}", function($id) use($app) {

            return $app['twig']->render('tag.twig',['tag'=>$app['TagsService']->find($id)]);

        })->bind("tag");


        $tags->post("/", function(Request $request) use($app) {
            $data['nome'] = $request->get('nome');

            $validator = $app['TagsService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                $dados = $app['TagsService']->findAll();
                return $app['twig']->render('tags.twig',['tags'=>$dados, 'errors'=>$validator->getLogErrors()]);
            }

            $result = $app['TagsService']->insert($data);
            $dados = $app['TagsService']->findAll();

            return $app['twig']->render('tags.twig',['tags'=>$dados, 'result'=>$result]);

        })->bind('cadastrar_tag');


        $tags->put("/{id}", function(Request $request, $id) use($app) {
            $data['nome'] = $request->get('nome');

            $validator = $app['TagsService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                $dados = $app['TagsService']->findAll();
                return $app['twig']->render('tags.twig',['tags'=>$dados, 'errors'=>$validator->getLogErrors()]);
            }

            $result = $app['TagsService']->update($id, $data);
            $dados = $app['TagsService']->findAll();

            return $app['twig']->render('tags.twig',['tags'=>$dados, 'result'=>$result]);

        })->bind('alterar_tag');


        $tags->delete("/{id}", function($id) use($app) {

            $result = $app['TagsService']->delete($id);
            $dados = $app['TagsService']->findAll();

            return $app['twig']->render('tags.twig',['tags'=>$dados, 'result'=>$result]);

        })->bind("apagar_tag");

        return $tags;
    }

}