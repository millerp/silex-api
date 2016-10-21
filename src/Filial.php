<?php

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Filial.
 *
 * @ORM\Table(name="filial")
 * @ORM\Entity
 */
class Filial
{
    /**
     * @var int
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     *
     * @return Filial
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    public function toArray()
    {
        return [
            'id'   => $this->getId(),
            'nome' => $this->getNome(),
        ];
    }

    /*
     * Validator
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('nome', new NotBlank(['message' => 'Campo {nome} é obrigatório']));
    }
}
