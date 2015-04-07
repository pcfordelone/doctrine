<?php

$inicio = $app['controllers_factory'];

$inicio->get("/", function() use($app) {
    return $app['twig']->render('index.twig',[]);
})->bind('index');

return $inicio;