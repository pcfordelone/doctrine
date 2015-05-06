<?php

namespace FRD\Sistema\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use FRD\Sistema\App;
use FRD\Sistema\Entity\CategoriaSerializer;
use FRD\Sistema\Entity\Produto;
use FRD\Sistema\Entity\CategoriaProduto;
use FRD\Sistema\Logger\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class ApiCategoriaProdutoService
{
    private $em;
    private $logger;
    private $produtoArray = [];

    function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    function insert(array $data)
    {

        $categoria = new CategoriaProduto();
        $categoria->setNome($data["nome"]);

        $this->em->persist($categoria);
        $this->em->flush();

        return $this->logger->success("Categoria {$data['nome']} adicionada com sucesso");

    }

    function update($id, array $data)
    {
        $categoria = $this->em->getReference("FRD\Sistema\Entity\CategoriaProduto", $id);

        $categoria->setNome($data["nome"]);

        $this->em->persist($categoria);
        $this->em->flush();

        return $this->logger->success("Categoria {$data['nome']} alterada com sucesso");
    }

    function delete($id)
    {
        $this->em->remove($this->em->getReference("FRD\Sistema\Entity\CategoriaProduto", $id));
        $this->em->flush();

        return $this->logger->danger("Categoria excluído com sucesso");
    }

    function findAll()
    {
        $data = $this->em->getRepository("FRD\Sistema\Entity\CategoriaProduto")->findAll();

        foreach ($data as $object) {
            $categoriaSerializer = new CategoriaSerializer();
            $this->produtoArray[] = $categoriaSerializer->serializer($object);
        }

        return $this->produtoArray;
    }

    function find($id)
    {
        $data = $this->em->getRepository("FRD\Sistema\Entity\CategoriaProduto")->find($id);
        $categoriaSerializer = new CategoriaSerializer();

        return $categoriaSerializer->serializer($data);
    }

    function validate(App $app, array $data)
    {

        $constraint = new Assert\Collection(array(
            'nome' => new Assert\NotBlank(),
        ));

        $validator = new ValidatorService($app, $data, $constraint);

        return $validator;
    }
} 