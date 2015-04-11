<?php

namespace FRD\Sistema\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

class IndexController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $inicio = $app['controllers_factory'];

        $inicio->get("/", function() use($app) {
            return $app['twig']->render('index.twig',[]);
        })->bind('index');

        return $inicio;
    }
}