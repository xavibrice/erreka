<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyReductionRepository")
 */
class PropertyReduction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="propertyReductions")
     */
    private $property;

    /**
     * @ORM\Column(type="date")
     */
    private $reduction_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $reduction_next_date;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $last_price;

    /**
     * @ORM\Column(type="float")
     */
    private $percentage;

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

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->price;
    }

    public function getReductionDate(): ?\DateTimeInterface
    {
        return $this->reduction_date;
    }

    public function setReductionDate(\DateTimeInterface $reduction_date): self
    {
        $this->reduction_date = $reduction_date;

        return $this;
    }

    public function getReductionNextDate(): ?\DateTimeInterface
    {
        return $this->reduction_next_date;
    }

    public function setReductionNextDate(?\DateTimeInterface $reduction_next_date): self
    {
        $this->reduction_next_date = $reduction_next_date;

        return $this;
    }

    public function getLastPrice()
    {
        return $this->last_price;
    }

    public function setLastPrice($last_price): self
    {
        $this->last_price = $last_price;

        return $this;
    }

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    public function setPercentage(float $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }
}
