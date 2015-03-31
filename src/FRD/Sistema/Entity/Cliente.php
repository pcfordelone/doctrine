<?php

namespace FRD\Sistema\Entity;


class Cliente
{
    private $id, $nome, $email, $cpfCnpj;

    public function setCpfCnpj($cpfCnpj) { $this->cpfCnpj = $cpfCnpj; return $this; }
    public function getCpfCnpj() { return $this->cpfCnpj; }

    public function setEmail($email) { $this->email = $email; return $this; }
    public function getEmail() { return $this->email; }

    public function setNome($nome) { $this->nome = $nome; return $this; }
    public function getNome() { return $this->nome; }

    public function setId($id) { $this->id = $id; return $this; }
    public function getId() { return $this->id; }

}