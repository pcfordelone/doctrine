<?php

namespace FRD\Sistema\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ApiTagController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        Request::enableHttpMethodParameterOverride();

        $api_tag = $app['controllers_factory'];

        $api_tag->get("/", function() use($app) {
            $data = $app['TagsService']->findAllApi();

            return $app->json($data);
        });


        $api_tag->get("/{id}", function($id) use($app) {
            $data = $app['TagsService']->find($id);

            return $app->json($data[0]);
        });


        $api_tag->post("/", function(Request $request) use($app) {
            $data['nome'] = $request->get('nome');

            $app['TagsService']->insert($data);
            return $app->json($data);
        });

        return $api_tag;
    }

} 