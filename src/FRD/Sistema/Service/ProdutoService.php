<?php

namespace FRD\Sistema\Service;

use Doctrine\ORM\EntityManager;
use FRD\Sistema\Entity\Produto;
use FRD\Sistema\Mapper\ProdutoMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class ProdutoService
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
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

        return $produto->getId();
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

        return $produto;
    }

    function delete($id)
    {
        $produto = $this->em->getReference("FRD\Sistema\Entity\Produto", $id);
        $this->em->remove($produto);
        $this->em->flush();

        return true;
    }

    function findAll()
    {
        $produto = $this->em->getRepository("FRD\Sistema\Entity\Produto");
        $result = $produto->findAll();

        return $result;
    }

    function find($id)
    {
        $produto = $this->em->getRepository("FRD\Sistema\Entity\Produto");

        return $produto->find($id);;
    }

    function buscar($keyword)
    {
        $produto = $this->em->getRepository("FRD\Sistema\Entity\Produto");

        return $produto->buscar($keyword);
    }
} 