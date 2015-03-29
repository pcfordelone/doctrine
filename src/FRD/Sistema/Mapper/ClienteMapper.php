<?php

namespace FRD\Sistema\Mapper;


use FRD\Sistema\Entity\Cliente;

class ClienteMapper
{
    private $cliente;

    function insert(Cliente $cliente)
    {
        return [
            'nome'=>$cliente->getNome(),
            'email'=>$cliente->getEmail(),
            'cpfCnpj'=>$cliente->getCpfCnpj()
        ];
    }
} 