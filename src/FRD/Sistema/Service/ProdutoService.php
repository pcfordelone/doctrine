<?php

namespace FRD\Sistema\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use FRD\Sistema\App;
use FRD\Sistema\Entity\Produto;
use FRD\Sistema\Logger\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class ProdutoService
{
    private $em;
    private $logger;
    private $logErrors;

    function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    function insert(array $data)
    {

        $produto = new Produto();
        $produto
            ->setNome($data["nome"])
            ->setDescricao($data["descricao"])
            ->setValor($data["valor"])
        ;

        $this->em->persist($produto);
        $this->em->flush();

        return $this->logger->success("Produto {$data['nome']} adicionado com sucesso");

    }

    function update($id, array $data)
    {
        $produto = $this->em->getReference("FRD\Sistema\Entity\Produto", $id);
        $produto
            ->setNome($data["nome"])
            ->setDescricao($data["descricao"])
            ->setValor($data["valor"])
        ;

        $this->em->persist($produto);
        $this->em->flush();

        return $this->logger->success("Produto {$data['nome']} alterado com sucesso");
    }

    function delete($id)
    {
        $this->em->remove($this->em->getReference("FRD\Sistema\Entity\Produto", $id));
        $this->em->flush();

        return $this->logger->danger("Produto excluído com sucesso");
    }

    function findAll()
    {
        return $this->em->getRepository("FRD\Sistema\Entity\Produto")->findAll();
    }

    function find($id)
    {
        return $this->em->getRepository("FRD\Sistema\Entity\Produto")->find($id);
    }

    function buscar($keyword, $pag, $max)
    {
        return $this->em->getRepository("FRD\Sistema\Entity\Produto")->buscar($keyword, $pag, $max);
    }

    function validate(App $app, array $data)
    {

        $constraint = new Assert\Collection(array(
            'nome' => new Assert\NotBlank(),
            'valor' => new Assert\NotEqualTo(0),
            'descricao' => new Assert\NotBlank(),
        ));

        $validator = new ValidatorService($app, $data, $constraint);

        return $validator;
    }
} 