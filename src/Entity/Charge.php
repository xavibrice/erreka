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

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expiration_date;

    /**
     * @ORM\Column(type="date")
     */
    private $start_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $end_date;

    public function __construct()
    {
        $this->rate_housing = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(?\DateTimeInterface $expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

}
