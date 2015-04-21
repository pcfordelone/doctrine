<?php

namespace FRD\Sistema\Service;

use FRD\Sistema\App;
use Symfony\Component\Validator\Constraints as Assert;


class ValidatorService
{
    private $logErrors = [];

    function __construct(App $app, array $data, Assert\Collection $constraint)
    {
        $errors = $app['validator']->validateValue($data, $constraint);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $this->addError($error->getPropertyPath().' '.$error->getMessage()."<br/>\n");
            }
            return false;
        }
        return true;
    }

    function addError($error)
    {
        $this->logErrors[] = $error;
    }

    function getLogErrors()
    {
        return $this->logErrors;
    }
}