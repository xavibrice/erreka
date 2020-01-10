<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroundRepository")
 */
class Ground
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
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="ground")
     */
    private $rate_housing;

    public function __construct()
    {
        $this->rate_housing = new ArrayCollection();
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
    public function getRateHousing(): Collection
    {
        return $this->rate_housing;
    }

    public function addRateHousing(RateHousing $rateHousing): self
    {
        if (!$this->rate_housing->contains($rateHousing)) {
            $this->rate_housing[] = $rateHousing;
            $rateHousing->setGround($this);
        }

        return $this;
    }

    public function removeRateHousing(RateHousing $rateHousing): self
    {
        if ($this->rate_housing->contains($rateHousing)) {
            $this->rate_housing->removeElement($rateHousing);
            // set the owning side to null (unless already changed)
            if ($rateHousing->getGround() === $this) {
                $rateHousing->setGround(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->name;
    }
}
