<?php

namespace App\Model;

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $cpf;

    /**
     * Retorna o valor de ID
     * 
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retorna o valor de CPF
     * 
     * @return string
     */
    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    /**
     * Define o valor de CPF
     *
     * @return  self
     */
    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Retorna o valor de name
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Define o valor de name
     *
     * @return  self
     */
    public function setname($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
