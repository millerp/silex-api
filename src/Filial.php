<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Filial
 *
 * @ORM\Table(name="filial")
 * @ORM\Entity
 */
class Filial
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


}
