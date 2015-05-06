<?php

namespace FRD\Sistema\Entity;



class ProdutoSerializer
{
    private $tags;

    public function serializer(Produto $produto)
    {
        foreach ($produto->getTags() as $tag) {
            $this->tags [] = $tag->getId();
        }

        $produto = array(
            'id'=>$produto->getId(),
            'nome'=>$produto->getNome(),
            'categoria'=>$produto->getCategoria()->getNome(),
            'valor'=>$produto->getValor(),
            'descricao'=>$produto->getDescricao(),
            'tags'=>$this->tags
        );

        return $produto;
    }

    public function deserialize(array $produto)
    {
        $c = new Produto();

        foreach ($produto as $key => $value) {
            $setter = "set" . ucfirst($key);
            if (method_exists($c, $setter)) {
                $c->$setter($value);
            }
        }
        return $c;
    }
} 