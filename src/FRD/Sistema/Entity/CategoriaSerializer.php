<?php

namespace FRD\Sistema\Entity;



class CategoriaSerializer
{
    public function serializer(CategoriaProduto $categoria)
    {
        $categoria = array(
            'id'=>$categoria->getId(),
            'nome'=>$categoria->getNome(),
        );

        return $categoria;
    }
} 