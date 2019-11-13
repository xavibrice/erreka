<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnergyCertificateRepository")
 */
class EnergyCertificate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="energy_certificate")
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

    public function setName(?string $name): self
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
            $rateHousing->setEnergyCertificate($this);
        }

        return $this;
    }

    public function removeRateHousing(RateHousing $rateHousing): self
    {
        if ($this->rateHousings->contains($rateHousing)) {
            $this->rateHousings->removeElement($rateHousing);
            // set the owning side to null (unless already changed)
            if ($rateHousing->getEnergyCertificate() === $this) {
                $rateHousing->setEnergyCertificate(null);
            }
        }

        return $this;
    }
}
