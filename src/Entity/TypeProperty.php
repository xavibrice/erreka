<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypePropertyRepository")
 */
class TypeProperty
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Property", mappedBy="typeProperty")
     */
    private $property;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_property;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="typeProperty")
     */
    private $clients;

    public function __construct()
    {
        $this->property = new ArrayCollection();
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperty(): Collection
    {
        return $this->property;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->property->contains($property)) {
            $this->property[] = $property;
            $property->setTypeProperty($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->property->contains($property)) {
            $this->property->removeElement($property);
            // set the owning side to null (unless already changed)
            if ($property->getTypeProperty() === $this) {
                $property->setTypeProperty(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->name;
    }

    public function getIsProperty(): ?bool
    {
        return $this->is_property;
    }

    public function setIsProperty(bool $is_property): self
    {
        $this->is_property = $is_property;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setTypeProperty($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getTypeProperty() === $this) {
                $client->setTypeProperty(null);
            }
        }

        return $this;
    }

}
