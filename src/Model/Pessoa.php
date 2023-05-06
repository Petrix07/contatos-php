<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pessoa")
 */
class Pessoa
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
    private $nome;

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
     * Retorna o valor de nome
     * @return string
     */
    public function getNome(): ?string
    {
        return $this->nome;
    }

    /**
     * Define o valor de nome
     *
     * @return  self
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }
}
