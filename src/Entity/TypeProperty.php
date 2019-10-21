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
     * @ORM\Column(type="string", length=255)
     */
    private $name_slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $template;

    public function __construct()
    {
        $this->property = new ArrayCollection();
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

    public function getNameSlug(): ?string
    {
        return $this->name_slug;
    }

    public function setNameSlug(string $name_slug): self
    {
        $this->name_slug = $name_slug;

        return $this;
    }

    public function getTemplate(): ?int
    {
        return $this->template;
    }

    public function setTemplate(int $template): self
    {
        $this->template = $template;

        return $this;
    }
}
