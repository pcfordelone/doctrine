<?php

namespace FRD\Sistema\Service;

use FRD\Sistema\Entity\Produto;
use FRD\Sistema\Mapper\ProdutoMapper;
use Symfony\Component\Validator\Constraints as Assert;


class ProdutoService
{
    private $produto, $mapper;

    function __construct(Produto $produto, ProdutoMapper $mapper)
    {
        $this->produto = $produto;
        $this->mapper = $mapper;
    }

    function insert(array $data)
    {
        $this->produto->setNome($data['nome']);
        $this->produto->setDescricao($data['descricao']);
        $this->produto->setValor($data['valor']);


        return $this->mapper->insert($this->produto);
    }

    function update(array $data)
    {
        $this->produto->setId($data['id']);
        $this->produto->setNome($data['nome']);
        $this->produto->setDescricao($data['descricao']);
        $this->produto->setValor($data['valor']);

        return $this->mapper->update($this->produto);
    }

    function delete($id)
    {
        return $this->mapper->delete($id);
    }

    function fetchAll()
    {
        return $this->mapper->fetchAll();
    }

    function find($id)
    {
        return $this->mapper->find($id);
    }
} 