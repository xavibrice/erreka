<?php

namespace App\Entity;

class SearchFronted
{
    const SELL_OR_RENT = [
        0 => 'Compra',
        1 => 'Alquiler',
    ];

    /**
     * @var int|null
     */
    private $bedrooms;

    /**
     * @var int|null
     */
    private $price;

    private $typeProperty;

    /**
     * @return int|null
     */
    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    /**
     * @param int|null $bedrooms
     */
    public function setBedrooms(?int $bedrooms): void
    {
        $this->bedrooms = $bedrooms;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     */
    public function setPrice(?int $price): void
    {
        $this->price = $price;
    }

    public function getTypeProperty(): ?TypeProperty
    {
        return $this->typeProperty;
    }

    public function setTypeProperty(?TypeProperty $typeProperty)
    {
        $this->typeProperty = $typeProperty;
    }

}
