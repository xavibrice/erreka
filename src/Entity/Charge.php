<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChargeRepository")
 */
class Charge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $house_key;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $price_ok;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ChargeType", inversedBy="charges")
     */
    private $charge_type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="charge")
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

    public function getHouseKey(): ?bool
    {
        return $this->house_key;
    }

    public function setHouseKey(bool $house_key): self
    {
        $this->house_key = $house_key;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceOk()
    {
        return $this->price_ok;
    }

    public function setPriceOk($price_ok): self
    {
        $this->price_ok = $price_ok;

        return $this;
    }

    public function getChargeType(): ?ChargeType
    {
        return $this->charge_type;
    }

    public function setChargeType(?ChargeType $charge_type): self
    {
        $this->charge_type = $charge_type;

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
            $rateHousing->setCharge($this);
        }

        return $this;
    }

    public function removeRateHousing(RateHousing $rateHousing): self
    {
        if ($this->rate_housing->contains($rateHousing)) {
            $this->rate_housing->removeElement($rateHousing);
            // set the owning side to null (unless already changed)
            if ($rateHousing->getCharge() === $this) {
                $rateHousing->setCharge(null);
            }
        }

        return $this;
    }

}
