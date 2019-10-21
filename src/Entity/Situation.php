<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SituationRepository")
 * @UniqueEntity("name", message="Situación ya existe, crea otra.")
 */
class Situation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Unique(message="Ya existe una situación con ese nombre.")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reason", mappedBy="situation", orphanRemoval=true, cascade={"persist"}))
     */
    private $reason;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_slug;

    public function __construct()
    {
        $this->reason = new ArrayCollection();
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
     * @return Collection|Reason[]
     */
    public function getReason(): Collection
    {
        return $this->reason;
    }

    public function addReason(Reason $reason): self
    {
        if (!$this->reason->contains($reason)) {
            $this->reason[] = $reason;
            $reason->setSituation($this);
        }

        return $this;
    }

    public function removeReason(Reason $reason): self
    {
        if ($this->reason->contains($reason)) {
            $this->reason->removeElement($reason);
            // set the owning side to null (unless already changed)
            if ($reason->getSituation() === $this) {
                $reason->setSituation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->name;
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
}
