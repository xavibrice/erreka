<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RateHousingRepository")
 */
class RateHousing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $visited;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $min_price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $max_price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pets;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bathrooms;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $approx_meters;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $real_meters;

    /**
     * @ORM\Column(type="boolean")
     */
    private $living_room;

    /**
     * @ORM\Column(type="boolean")
     */
    private $balcony;

    /**
     * @ORM\Column(type="boolean")
     */
    private $terrace;

    /**
     * @ORM\Column(type="boolean")
     */
    private $suit_bathroom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $video_intercom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $storage_room;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pantry;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fitted_wardrobes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $direct_garage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disabled_access;

    /**
     * @ORM\Column(type="boolean")
     */
    private $zero_dimension;

    /**
     * @ORM\Column(type="boolean")
     */
    private $security_door;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\News", inversedBy="rate_housing")
     * @ORM\JoinColumn(name="new_id", referencedColumnName="id")
     */
    private $new;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Property", inversedBy="rate_housing")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    private $property;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ValuationStatus", inversedBy="bathroom_state")
     */
    private $bathroomState;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ValuationStatus", inversedBy="been_cooking")
     */
    private $beenCooking;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ValuationStatus", inversedBy="windows_state")
     */
    private $windowsState;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ValuationStatus", inversedBy="been_walls")
     */
    private $beenWalls;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ValuationStatus", inversedBy="doors_state")
     */
    private $doorsState;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ValuationStatus", inversedBy="ground_state")
     */
    private $groundState;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisited(): ?\DateTimeInterface
    {
        return $this->visited;
    }

    public function setVisited(\DateTimeInterface $visited): self
    {
        $this->visited = $visited;

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

    public function getMinPrice()
    {
        return $this->min_price;
    }

    public function setMinPrice($min_price): self
    {
        $this->min_price = $min_price;

        return $this;
    }

    public function getMaxPrice()
    {
        return $this->max_price;
    }

    public function setMaxPrice($max_price): self
    {
        $this->max_price = $max_price;

        return $this;
    }

    public function getPets(): ?bool
    {
        return $this->pets;
    }

    public function setPets(bool $pets): self
    {
        $this->pets = $pets;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getBathrooms(): ?int
    {
        return $this->bathrooms;
    }

    public function setBathrooms(int $bathrooms): self
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    public function getApproxMeters(): ?int
    {
        return $this->approx_meters;
    }

    public function setApproxMeters(?int $approx_meters): self
    {
        $this->approx_meters = $approx_meters;

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

    public function getLivingRoom(): ?bool
    {
        return $this->living_room;
    }

    public function setLivingRoom(bool $living_room): self
    {
        $this->living_room = $living_room;

        return $this;
    }

    public function getBalcony(): ?bool
    {
        return $this->balcony;
    }

    public function setBalcony(bool $balcony): self
    {
        $this->balcony = $balcony;

        return $this;
    }

    public function getTerrace(): ?bool
    {
        return $this->terrace;
    }

    public function setTerrace(bool $terrace): self
    {
        $this->terrace = $terrace;

        return $this;
    }

    public function getSuitBathroom(): ?bool
    {
        return $this->suit_bathroom;
    }

    public function setSuitBathroom(bool $suit_bathroom): self
    {
        $this->suit_bathroom = $suit_bathroom;

        return $this;
    }

    public function getVideoIntercom(): ?bool
    {
        return $this->video_intercom;
    }

    public function setVideoIntercom(bool $video_intercom): self
    {
        $this->video_intercom = $video_intercom;

        return $this;
    }

    public function getStorageRoom(): ?bool
    {
        return $this->storage_room;
    }

    public function setStorageRoom(bool $storage_room): self
    {
        $this->storage_room = $storage_room;

        return $this;
    }

    public function getPantry(): ?bool
    {
        return $this->pantry;
    }

    public function setPantry(bool $pantry): self
    {
        $this->pantry = $pantry;

        return $this;
    }

    public function getFittedWardrobes(): ?bool
    {
        return $this->fitted_wardrobes;
    }

    public function setFittedWardrobes(bool $fitted_wardrobes): self
    {
        $this->fitted_wardrobes = $fitted_wardrobes;

        return $this;
    }

    public function getDirectGarage(): ?bool
    {
        return $this->direct_garage;
    }

    public function setDirectGarage(bool $direct_garage): self
    {
        $this->direct_garage = $direct_garage;

        return $this;
    }

    public function getDisabledAccess(): ?bool
    {
        return $this->disabled_access;
    }

    public function setDisabledAccess(bool $disabled_access): self
    {
        $this->disabled_access = $disabled_access;

        return $this;
    }

    public function getZeroDimension(): ?bool
    {
        return $this->zero_dimension;
    }

    public function setZeroDimension(bool $zero_dimension): self
    {
        $this->zero_dimension = $zero_dimension;

        return $this;
    }

    public function getSecurityDoor(): ?bool
    {
        return $this->security_door;
    }

    public function setSecurityDoor(bool $security_door): self
    {
        $this->security_door = $security_door;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * @param mixed $new
     */
    public function setNew($new): void
    {
        $this->new = $new;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->getComment();
    }

    public function getBathroomState(): ?ValuationStatus
    {
        return $this->bathroomState;
    }

    public function setBathroomState(?ValuationStatus $bathroomState): self
    {
        $this->bathroomState = $bathroomState;

        return $this;
    }

    public function getBeenCooking(): ?ValuationStatus
    {
        return $this->beenCooking;
    }

    public function setBeenCooking(?ValuationStatus $beenCooking): self
    {
        $this->beenCooking = $beenCooking;

        return $this;
    }

    public function getWindowsState(): ?ValuationStatus
    {
        return $this->windowsState;
    }

    public function setWindowsState(?ValuationStatus $windowsState): self
    {
        $this->windowsState = $windowsState;

        return $this;
    }

    public function getBeenWalls(): ?ValuationStatus
    {
        return $this->beenWalls;
    }

    public function setBeenWalls(?ValuationStatus $beenWalls): self
    {
        $this->beenWalls = $beenWalls;

        return $this;
    }

    public function getDoorsState(): ?ValuationStatus
    {
        return $this->doorsState;
    }

    public function setDoorsState(?ValuationStatus $doorsState): self
    {
        $this->doorsState = $doorsState;

        return $this;
    }

    public function getGroundState(): ?ValuationStatus
    {
        return $this->groundState;
    }

    public function setGroundState(?ValuationStatus $groundState): self
    {
        $this->groundState = $groundState;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param mixed $property
     */
    public function setProperty($property): void
    {
        $this->property = $property;
    }

}
