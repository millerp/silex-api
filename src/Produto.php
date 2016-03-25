<?php
use Doctrine\ORM\Mapping as ORM;

/**
 * Produto
 *
 * @ORM\Table(name="produto", indexes={@ORM\Index(name="fabricante_id", columns={"fabricante_id"}), @ORM\Index(name="estoque_id", columns={"estoque_id"})})
 * @ORM\Entity
 */
class Produto
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
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="garantia", type="string", length=30, nullable=true)
     */
    private $garantia;

    /**
     * @var string
     *
     * @ORM\Column(name="grade", type="string", length=30, nullable=true)
     */
    private $grade;

    /**
     * @var \Fabricante
     *
     * @ORM\ManyToOne(targetEntity="Fabricante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fabricante_id", referencedColumnName="id")
     * })
     */
    private $fabricante;

    /**
     * @var \Estoque
     *
     * @ORM\OneToMany(targetEntity="Estoque",mappedBy="produto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="produto_id")
     * })
     */
    private $estoque;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getGarantia()
    {
        return $this->garantia;
    }

    /**
     * @param string $garantia
     */
    public function setGarantia($garantia)
    {
        $this->garantia = $garantia;
    }

    /**
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param string $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return Fabricante
     */
    public function getFabricante()
    {
        return $this->fabricante;
    }

    /**
     * @param Fabricante $fabricante
     */
    public function setFabricante($fabricante)
    {
        $this->fabricante = $fabricante;
    }

    /**
     * @return Estoque
     */
    public function getEstoque()
    {
        return $this->estoque;
    }

    /**
     * @param Estoque $estoque
     */
    public function setEstoque($estoque)
    {
        $this->estoque = $estoque;
    }

}
