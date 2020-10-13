<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeGarageRepository")
 */
class TypeGarage
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
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="type_garage")
     */
    private $rateHousings;

    public function __construct()
    {
        $this->rateHousings = new ArrayCollection();
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
     * @return Collection|RateHousing[]
     */
    public function getRateHousings(): Collection
    {
        return $this->rateHousings;
    }

    public function addRateHousing(RateHousing $rateHousing): self
    {
        if (!$this->rateHousings->contains($rateHousing)) {
            $this->rateHousings[] = $rateHousing;
            $rateHousing->setTypeGarage($this);
        }

        return $this;
    }

    public function removeRateHousing(RateHousing $rateHousing): self
    {
        if ($this->rateHousings->contains($rateHousing)) {
            $this->rateHousings->removeElement($rateHousing);
            // set the owning side to null (unless already changed)
            if ($rateHousing->getTypeGarage() === $this) {
                $rateHousing->setTypeGarage(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
