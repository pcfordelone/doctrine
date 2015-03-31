<?php

namespace FRD\Sistema\Service;


use FRD\Sistema\Entity\Cliente;
use FRD\Sistema\Mapper\ClienteMapper;

class ClienteService
{
    private $cliente, $mapper;

    function __construct(Cliente $cliente, ClienteMapper $mapper)
    {
        $this->cliente = $cliente;
        $this->mapper = $mapper;
    }

    function insert(array $data)
    {
        $cliente = $this->cliente;
        $cliente->setNome($data['nome']);
        $cliente->setEmail($data['email']);
        $cliente->setCpfCnpj($data['cpfCnpj']);

        $mapper = $this->mapper;
        return $mapper->insert($cliente);
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