<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
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
    private $full_name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Property", mappedBy="visits")
     */
    private $properties;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $real_meters;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bathrooms;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Heating", inversedBy="clients")
     */
    private $heating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orientation", inversedBy="clients")
     */
    private $orientation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $terrace;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $suit_bathroom;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $direct_garage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $video_intercom;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $storage_room;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $disabled_access;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $zero_dimension;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $elevator;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

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

    /**
     * @return Collection|Property[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->addVisit($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->contains($property)) {
            $this->properties->removeElement($property);
            $property->removeVisit($this);
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->full_name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getRealMeters(): ?int
    {
        return $this->real_meters;
    }

    public function setRealMeters(?int $real_meters): self
    {
        $this->real_meters = $real_meters;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(?int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getBathrooms(): ?int
    {
        return $this->bathrooms;
    }

    public function setBathrooms(?int $bathrooms): self
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    public function getHeating(): ?Heating
    {
        return $this->heating;
    }

    public function setHeating(?Heating $heating): self
    {
        $this->heating = $heating;

        return $this;
    }

    public function getOrientation(): ?Orientation
    {
        return $this->orientation;
    }

    public function setOrientation(?Orientation $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getTerrace(): ?bool
    {
        return $this->terrace;
    }

    public function setTerrace(?bool $terrace): self
    {
        $this->terrace = $terrace;

        return $this;
    }

    public function getSuitBathroom(): ?bool
    {
        return $this->suit_bathroom;
    }

    public function setSuitBathroom(?bool $suit_bathroom): self
    {
        $this->suit_bathroom = $suit_bathroom;

        return $this;
    }

    public function getDirectGarage(): ?bool
    {
        return $this->direct_garage;
    }

    public function setDirectGarage(?bool $direct_garage): self
    {
        $this->direct_garage = $direct_garage;

        return $this;
    }

    public function getVideoIntercom(): ?bool
    {
        return $this->video_intercom;
    }

    public function setVideoIntercom(?bool $video_intercom): self
    {
        $this->video_intercom = $video_intercom;

        return $this;
    }

    public function getStorageRoom(): ?bool
    {
        return $this->storage_room;
    }

    public function setStorageRoom(?bool $storage_room): self
    {
        $this->storage_room = $storage_room;

        return $this;
    }

    public function getDisabledAccess(): ?bool
    {
        return $this->disabled_access;
    }

    public function setDisabledAccess(?bool $disabled_access): self
    {
        $this->disabled_access = $disabled_access;

        return $this;
    }

    public function getZeroDimension(): ?bool
    {
        return $this->zero_dimension;
    }

    public function setZeroDimension(?bool $zero_dimension): self
    {
        $this->zero_dimension = $zero_dimension;

        return $this;
    }

    public function getElevator(): ?bool
    {
        return $this->elevator;
    }

    public function setElevator(?bool $elevator): self
    {
        $this->elevator = $elevator;

        return $this;
    }
}
