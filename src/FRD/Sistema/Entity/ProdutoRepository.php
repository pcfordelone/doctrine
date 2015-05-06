<?php

namespace FRD\Sistema\Entity;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;


class ProdutoRepository extends EntityRepository
{
    public function buscar($keyword, $pag, $max)
    {
        /*$dql = "SELECT p FROM FRD\Sistema\Entity\Produto p
                    WHERE p.descricao LIKE '{$keyword}'
                    OR p.nome LIKE '{$keyword}'"*/
        ;
        $dql = "SELECT p, t FROM FRD\Sistema\Entity\Produto p JOIN p.tags t
                    WHERE p.descricao LIKE '{$keyword}'
                    OR p.nome LIKE '{$keyword}'
                    OR t.nome LIKE '{$keyword}'
                    ";

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

    public function findAllApi()
    {
        $dql = "SELECT p FROM FRD\Sistema\Entity\Produto p";

        return
            $this
                ->getEntityManager()
                ->createQuery($dql)
                ->getResult(AbstractQuery::HYDRATE_ARRAY);
        ;

    }

    public function findApi($id)
    {
        return $this
                ->getEntityManager()
                ->createQuery("SELECT p FROM FRD\Sistema\Entity\Produto p WHERE p.id = '{$id}'")
                ->getResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }
} 