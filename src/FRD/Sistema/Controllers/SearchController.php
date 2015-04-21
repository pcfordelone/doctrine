<?php

namespace FRD\Sistema\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

class SearchController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $busca = $app['controllers_factory'];

        $busca->get("/", function() use($app) {
            return $app['twig']->render('search.twig',[]);
        })->bind('search_index');

        return $busca;
    }
}