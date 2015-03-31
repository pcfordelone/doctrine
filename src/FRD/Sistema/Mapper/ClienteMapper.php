<?php

namespace FRD\Sistema\Mapper;


use FRD\Sistema\Entity\Cliente;

class ClienteMapper
{
    private $cliente, $pdo;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function insert(Cliente $cliente)
    {
        $query = "INSERT INTO clientes (nome, email, cpfCnpj) VALUE(:nome, :email, :cpfCnpj)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":nome", $cliente->getNome());
        $stmt->bindValue(":email", $cliente->getEmail());
        $stmt->bindValue(":cpfCnpj", $cliente->getCpfCnpj());

        if ($stmt->execute()) {
            return "Dados persistidos com sucesso";
        };

    }

    function fetchAll()
    {
        $query = "SELECT * from clientes";
        $stmt = $this->pdo->query($query);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    function find($id)
    {
        $query = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);

        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        };
    }
} 