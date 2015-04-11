<?php

require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\Validator\Constraints as Assert;
use FRD\Sistema\App as Application;

$app = new Application(array(
    "debug" => true
));

$app->run();