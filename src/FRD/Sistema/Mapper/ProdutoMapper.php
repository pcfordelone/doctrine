<?php

namespace FRD\Sistema\Mapper;

use FRD\Sistema\Entity\Produto;


class ProdutoMapper
{
    private $pdo;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function insert(Produto $produto)
    {
        $query = "INSERT INTO produtos (nome, descricao, valor) VALUE(:nome, :descricao, :valor)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":nome", $produto->getNome());
        $stmt->bindValue(":descricao", $produto->getDescricao());
        $stmt->bindValue(":valor", $produto->getValor());

        if ($stmt->execute()) {
            return "Dados persistidos com sucesso";
        };
    }

    function update(Produto $produto)
    {
        $query = "UPDATE produtos SET nome = :nome, descricao = :descricao, valor = :valor WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $produto->getId());
        $stmt->bindValue(":nome", $produto->getNome());
        $stmt->bindValue(":descricao", $produto->getDescricao());
        $stmt->bindValue(":valor", $produto->getValor());

        if ($stmt->execute()) {
            return "Dados persistidos com sucesso";
        };
    }

    function delete($id)
    {
        $query = "DELETE from produtos WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);

        if ($stmt->execute()) {
            return "Produto excluido com sucesso.";
        }
    }

    function fetchAll()
    {
        $query = "SELECT * from produtos";
        $stmt = $this->pdo->query($query);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    function find($id)
    {
        $query = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);

        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        };
    }
} 