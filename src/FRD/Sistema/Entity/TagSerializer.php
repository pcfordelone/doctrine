<?php

namespace FRD\Sistema\Entity;


class TagSerializer
{
    public function serializer(Tag $tag)
    {
        $tag = array(
            'id'=>$tag->getId(),
            'nome'=>$tag->getNome(),
        );

        return $tag;
    }

} 