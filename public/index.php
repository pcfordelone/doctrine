<?php

require_once __DIR__.'/../bootstrap.php';

$app->get("/ola/{nome}", function($nome) {
    return "Olá {$nome}";
});

$app->get("/clientes", function() use($app) {
    $dados['nome'] = 'Cliente X';
    $dados['email'] = 'clientex@gmail.com';

    $clienteService = new \FRD\Sistema\Service\ClienteService();
    $result = $clienteService->insert($dados);

    return $app->json($result);
});

$app->run();