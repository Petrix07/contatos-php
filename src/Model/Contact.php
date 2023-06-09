<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM, \App\Model\Person as Person;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 */
class Contact extends Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Person", cascade={"persist"})
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set the value of person
     *
     * @return  self
     */
    public function setPerson($person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Insere o registro informado
     * @param Contact $register
     * @param int $personId
     */
    public static function insertNewContact(Contact $newContact, int $personId): void
    {
        $connectiononnection = self::getConnection();
        $entityManager       = $connectiononnection->getEntityManager();
        $person              = $entityManager->getReference(Person::class, $personId);
        $newContact->setPerson($person);
        $entityManager->persist($newContact);
        $entityManager->flush();
    }
}
