<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Estoque
 *
 * @ORM\Table(name="estoque", indexes={@ORM\Index(name="filial_id", columns={"filial_id"}), @ORM\Index(name="produto_id", columns={"produto_id"})})
 * @ORM\Entity
 */
class Estoque
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantidade", type="integer", nullable=false)
     */
    private $quantidade;

    /**
     * @var \Filial
     *
     * @ORM\ManyToOne(targetEntity="Filial")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="filial_id", referencedColumnName="id")
     * })
     */
    private $filial;

    /**
     * @var \Produto
     *
     * @ORM\ManyToOne(targetEntity="Produto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produto_id", referencedColumnName="id")
     * })
     */
    private $produto;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * @param int $quantidade
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    /**
     * @return Filial
     */
    public function getFilial()
    {
        return $this->filial;
    }

    /**
     * @param Filial $filial
     */
    public function setFilial($filial)
    {
        $this->filial = $filial;
    }

    /**
     * @return Produto
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * @param Produto $produto
     */
    public function setProduto($produto)
    {
        $this->produto = $produto;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'quantidade' => $this->getQuantidade(),
            'filial' => $this->getFilial()->toArray(),
        ];
    }

}
