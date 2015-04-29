<?php

namespace FRD\Sistema\Entity;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;


class CategoriaProdutoRepository extends EntityRepository
{

    public function findAll()
    {
        return $this
            ->getEntityManager()
            ->createQuery("SELECT c FROM FRD\Sistema\Entity\CategoriaProduto c")
            ->getResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }

    public function find($id)
    {
        return $this
                ->getEntityManager()
                ->createQuery("SELECT p FROM FRD\Sistema\Entity\Produto p WHERE p.id = '{$id}'")
                ->getResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }
} 