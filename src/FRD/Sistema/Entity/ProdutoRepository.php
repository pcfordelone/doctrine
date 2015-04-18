<?php

namespace FRD\Sistema\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;


class ProdutoRepository extends EntityRepository
{
    public function buscar($keyword, $pag, $max)
    {
        $dql = "SELECT p FROM FRD\Sistema\Entity\Produto p
                    WHERE p.descricao LIKE '{$keyword}'
                    OR p.nome LIKE '{$keyword}'"
        ;

        echo $pag;

        $query =
            $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setFirstResult(($max * $pag) - $max)
            ->setMaxResults($max)
        ;

        $paginator =  new Paginator($query, $fetchJoinCollection = false);

        return $paginator;
    }
} 