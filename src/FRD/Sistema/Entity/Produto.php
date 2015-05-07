<?php

namespace FRD\Sistema\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="FRD\Sistema\Entity\ProdutoRepository")
 * @ORM\Table(name="produtos")
 */
class Produto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $valor;

    /**
     * @ORM\ManyToOne(targetEntity="FRD\Sistema\Entity\CategoriaProduto")
     * @ORM\JoinColumn(name="categ_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $categoria;

    /**
     * @ORM\ManyToMany(targetEntity="FRD\Sistema\Entity\Tag")
     * @ORM\JoinTable(name="produtos_tags",
 *          joinColumns={@ORM\JoinColumn(name="produto_id", referencedColumnName="id", onDelete="CASCADE")},
            inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function addTag($tag)
    {
        $this->tags->add($tag);
    }

    public function clearTags()
    {
        if (!$this->tags->isEmpty()) {
            $this->tags->clear();
        }
    }

    public function getTags()
    {
        return $this->tags;
    }
}