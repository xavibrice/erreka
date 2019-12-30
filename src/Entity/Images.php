<?php

namespace App\Entity;

use App\Service\UploaderHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImagesRepository")
 */
class Images
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
    private $name_image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RateHousing", inversedBy="image")
     */
    private $rateHousing;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameImage(): ?string
    {
        return $this->name_image;
    }

    public function setNameImage(?string $name_image): self
    {
        $this->name_image = $name_image;

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->name_image;
    }

    public function getImagePath()
    {
        return UploaderHelper::PROPERTY_IMAGE.'/'.$this->getNameImage();
    }

    public function getRateHousing(): ?RateHousing
    {
        return $this->rateHousing;
    }

    public function setRateHousing(?RateHousing $rateHousing): self
    {
        $this->rateHousing = $rateHousing;

        return $this;
    }
}
