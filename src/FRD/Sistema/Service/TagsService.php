<?php

namespace FRD\Sistema\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use FRD\Sistema\App;
use FRD\Sistema\Entity\Produto;
use FRD\Sistema\Entity\CategoriaProduto;
use FRD\Sistema\Entity\Tag;
use FRD\Sistema\Entity\TagSerializer;
use FRD\Sistema\Logger\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class TagsService
{
    private $em;
    private $logger;
    private $tagArray;

    function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    function insert(array $data)
    {
        $tag = new Tag();
        $tag->setNome($data["nome"]);

        $this->em->persist($tag);
        $this->em->flush();

        return $this->logger->success("Tag {$data['nome']} adicionada com sucesso");
    }

    function update($id, array $data)
    {
        $tag = $this->em->getReference("FRD\Sistema\Entity\Tag", $id);
        $tag
            ->setNome($data["nome"])
        ;

        $this->em->persist($tag);
        $this->em->flush();

        return $this->logger->success("Tag {$data['nome']} alterada com sucesso");
    }

    function delete($id)
    {
        $this->em->remove($this->em->getReference("FRD\Sistema\Entity\Tag", $id));
        $this->em->flush();

        return $this->logger->danger("Tag excluída com sucesso");
    }

    function findAll()
    {
        return $this->em->getRepository("FRD\Sistema\Entity\Tag")->findAll();
    }

    function findAllApi()
    {
        $data = $this->em->getRepository("FRD\Sistema\Entity\Tag")->findAll();
        $tagSerializer = new TagSerializer();

        foreach ($data as $object) {
            $this->tagArray[] = $tagSerializer->serializer($object);
        }

        return $this->tagArray;
    }

    function validate(App $app, array $data)
    {

        $constraint = new Assert\Collection(array(
            'nome' => new Assert\NotBlank()
        ));

        $validator = new ValidatorService($app, $data, $constraint);

        return $validator;
    }
} 