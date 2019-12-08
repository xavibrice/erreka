<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExclusiveRepository")
 */
class Exclusive
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

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
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $price_actual;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
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

    public function getPriceActual()
    {
        return $this->price_actual;
    }

    public function setPriceActual($price_actual): self
    {
        $this->price_actual = $price_actual;

        return $this;
    }
}
