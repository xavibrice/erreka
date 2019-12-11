<?php

namespace App\Entity;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\RateHousing", inversedBy="charges")
     */
    private $rate_housing;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ChargeType", inversedBy="charges")
     */
    private $charge_type;

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

    public function getRateHousing(): ?RateHousing
    {
        return $this->rate_housing;
    }

    public function setRateHousing(?RateHousing $rate_housing): self
    {
        $this->rate_housing = $rate_housing;

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

}
