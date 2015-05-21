<?php

namespace FRD\Sistema\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use FRD\Sistema\App;
use FRD\Sistema\Entity\Produto;
use FRD\Sistema\Entity\CategoriaProduto;
use FRD\Sistema\Entity\ProdutoSerializer;
use FRD\Sistema\Logger\Logger;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class ProdutoService
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

        $produto = new Produto();
        $produto
            ->setNome($data["nome"])
            ->setDescricao($data["descricao"])
            ->setValor($data["valor"])
        ;

        $categoria = $this->em->getReference("FRD\Sistema\Entity\CategoriaProduto", $data['categoria']);
        $produto->setCategoria($categoria);

        foreach ($data["tags"] as $tag_id) {
            $tag = $this->em->getReference("FRD\Sistema\Entity\Tag", $tag_id);
            $produto->addTag($tag);
        }

        $this->em->persist($produto);
        $this->em->flush();

        return $this->logger->success("Produto {$data['nome']} adicionado com sucesso");

    }

    function update($id, array $data)
    {
        $produto = $this->em->getReference("FRD\Sistema\Entity\Produto", $id);

        $produto->clearTags();
        $this->em->persist($produto);
        $this->em->flush();

        $produto
            ->setNome($data["nome"])
            ->setDescricao($data["descricao"])
            ->setValor($data["valor"])
        ;

        $categoria = $this->em->getReference("FRD\Sistema\Entity\CategoriaProduto", $data['categoria']);
        $produto->setCategoria($categoria);


        foreach ($data["tags"] as $tag_id) {
            $tag = $this->em->getReference("FRD\Sistema\Entity\Tag", $tag_id);
            $produto->addTag($tag);
        }

        if (!is_null($_FILES['image'])) {
            $upload = new UploadFileService();
            $produto->setImage($upload->upload());
        }

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

    function findAllApi()
    {
        $data = $this->em->getRepository("FRD\Sistema\Entity\Produto")->findAll();

        foreach ($data as $object) {
            $produtoSerializer = new ProdutoSerializer();
            $this->produtoArray[] = $produtoSerializer->serializer($object);
        }

        return $this->produtoArray;
    }

    function find($id)
    {
        return $this->em->getRepository("FRD\Sistema\Entity\Produto")->find($id);
    }

    function findApi($id)
    {
        return $this->em->getRepository("FRD\Sistema\Entity\Produto")->findApi($id);
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
            'categoria' => new Assert\NotNull(),
            'tags' => new Assert\NotBlank()
        ));

        $validator = new ValidatorService($app, $data, $constraint);

        return $validator;
    }
} 