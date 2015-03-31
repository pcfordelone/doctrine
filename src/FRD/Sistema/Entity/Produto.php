<?php

namespace FRD\Sistema\Entity;


class Produto
{
    private $id, $nome, $descricao, $valor;

    public function setId($id) { $this->id = $id; return $this; }
    public function getId() { return $this->id; }

    public function setNome($nome) { $this->nome = $nome; return $this; }
    public function getNome() { return $this->nome; }

    public function setDescricao($descricao) { $this->descricao = $descricao; return $this; }
    public function getDescricao() { return $this->descricao; }

    public function setValor($valor) { $this->valor = $valor; return $this; }
    public function getValor() { return $this->valor; }

}