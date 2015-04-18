<?php

namespace FRD\Sistema\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;


class ProdutoRepository extends EntityRepository
{
    public function buscar($keyword)
    {
        $dql = "SELECT p FROM FRD\Sistema\Entity\Produto p
                    WHERE p.descricao LIKE '{$keyword}'
                    OR p.nome LIKE '{$keyword}'"
        ;

        $query =
            $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setFirstResult(0)
            ->setMaxResults(2)
        ;

        $paginator =  new Paginator($query, $fetchJoinCollection = false);

        return $paginator;
    }
} 