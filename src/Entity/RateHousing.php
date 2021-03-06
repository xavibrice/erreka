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
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $min_price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $max_price;

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
    private $real_meters;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $storage_room;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $direct_garage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $disabled_access;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $zero_dimension;

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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Heating", inversedBy="rateHousings")
     */
    private $heating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Window", inversedBy="rateHousings")
     */
    private $window;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Door", inversedBy="rateHousings")
     */
    private $door;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $elevator;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $terrace;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $alarm_system;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $automatic_door;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $air_conditioning;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $antiquity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $community_expenses;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $pending_spills;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $amount_pending_spills;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $spills_future;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $administrator;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile_administrator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orientation", inversedBy="rateHousings")
     */
    private $orientation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EnergyCertificate", inversedBy="rateHousings")
     */
    private $energy_certificate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pets;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $exterior_bedrooms;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $patio_bedrooms;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $exterior_bathrooms;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $exterior_cooking;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Property", mappedBy="rateHousing")
     * @ORM\JoinColumn(name="rateHousing", referencedColumnName="id")
     */
    private $property;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Images", mappedBy="rateHousing", cascade={"persist"})
     */
    private $image;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $energyConsumption;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wall", inversedBy="rate_housing")
     */
    private $wall;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ground", inversedBy="rate_housing")
     */
    private $ground;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $balcony;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BuildingStructure", inversedBy="building_structure")
     */
    private $buildingStructure;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $shop_windows;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $plants;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeLocal", inversedBy="rateHousings")
     */
    private $type_local;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stays", inversedBy="rateHousings")
     */
    private $stays;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LocalGarageLocation", inversedBy="rateHousings")
     */
    private $local_garage_location;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $height;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $smoke_outlet;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $security_door;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $warehouse;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $equipped_kitchen;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $corner;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $closed_security_circuit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Size", inversedBy="rateHousings")
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeGarage", inversedBy="rateHousings")
     */
    private $type_garage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeStorageRoom", inversedBy="rateHousings")
     */
    private $type_storage_room;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $accesible_twenty_four_hours;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $loading_unloading_area;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StorageRoomLocation", inversedBy="rateHousings")
     */
    private $storage_room_location;

    public function __construct()
    {
        $this->property = new ArrayCollection();
        $this->image = new ArrayCollection();
    }

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

    public function getRealMeters(): ?int
    {
        return $this->real_meters;
    }

    public function setRealMeters(?int $real_meters): self
    {
        $this->real_meters = $real_meters;

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

    public function getHeating(): ?Heating
    {
        return $this->heating;
    }

    public function setHeating(?Heating $heating): self
    {
        $this->heating = $heating;

        return $this;
    }

    public function getWindow(): ?Window
    {
        return $this->window;
    }

    public function setWindow(?Window $window): self
    {
        $this->window = $window;

        return $this;
    }

    public function getDoor(): ?Door
    {
        return $this->door;
    }

    public function setDoor(?Door $door): self
    {
        $this->door = $door;

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

    public function getTerrace(): ?bool
    {
        return $this->terrace;
    }

    public function setTerrace(?bool $terrace): self
    {
        $this->terrace = $terrace;

        return $this;
    }

    public function getAlarmSystem(): ?bool
    {
        return $this->alarm_system;
    }

    public function setAlarmSystem(?bool $alarm_system): self
    {
        $this->alarm_system = $alarm_system;

        return $this;
    }

    public function getAutomaticDoor(): ?bool
    {
        return $this->automatic_door;
    }

    public function setAutomaticDoor(?bool $automatic_door): self
    {
        $this->automatic_door = $automatic_door;

        return $this;
    }

    public function getAirConditioning(): ?bool
    {
        return $this->air_conditioning;
    }

    public function setAirConditioning(?bool $air_conditioning): self
    {
        $this->air_conditioning = $air_conditioning;

        return $this;
    }

    public function getAntiquity(): ?int
    {
        return $this->antiquity;
    }

    public function setAntiquity(?int $antiquity): self
    {
        $this->antiquity = $antiquity;

        return $this;
    }

    public function getCommunityExpenses()
    {
        return $this->community_expenses;
    }

    public function setCommunityExpenses($community_expenses): self
    {
        $this->community_expenses = $community_expenses;

        return $this;
    }

    public function getPendingSpills(): ?string
    {
        return $this->pending_spills;
    }

    public function setPendingSpills(?string $pending_spills): self
    {
        $this->pending_spills = $pending_spills;

        return $this;
    }

    public function getAmountPendingSpills()
    {
        return $this->amount_pending_spills;
    }

    public function setAmountPendingSpills($amount_pending_spills): self
    {
        $this->amount_pending_spills = $amount_pending_spills;

        return $this;
    }

    public function getSpillsFuture(): ?string
    {
        return $this->spills_future;
    }

    public function setSpillsFuture(?string $spills_future): self
    {
        $this->spills_future = $spills_future;

        return $this;
    }

    public function getAdministrator(): ?string
    {
        return $this->administrator;
    }

    public function setAdministrator(?string $administrator): self
    {
        $this->administrator = $administrator;

        return $this;
    }

    public function getMobileAdministrator(): ?string
    {
        return $this->mobile_administrator;
    }

    public function setMobileAdministrator(?string $mobile_administrator): self
    {
        $this->mobile_administrator = $mobile_administrator;

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

    public function getEnergyCertificate(): ?EnergyCertificate
    {
        return $this->energy_certificate;
    }

    public function setEnergyCertificate(?EnergyCertificate $energy_certificate): self
    {
        $this->energy_certificate = $energy_certificate;

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

    public function getExteriorBedrooms(): ?int
    {
        return $this->exterior_bedrooms;
    }

    public function setExteriorBedrooms(?int $exterior_bedrooms): self
    {
        $this->exterior_bedrooms = $exterior_bedrooms;

        return $this;
    }

    public function getPatioBedrooms(): ?int
    {
        return $this->patio_bedrooms;
    }

    public function setPatioBedrooms(?int $patio_bedrooms): self
    {
        $this->patio_bedrooms = $patio_bedrooms;

        return $this;
    }

    public function getExteriorBathrooms(): ?int
    {
        return $this->exterior_bathrooms;
    }

    public function setExteriorBathrooms(?int $exterior_bathrooms): self
    {
        $this->exterior_bathrooms = $exterior_bathrooms;

        return $this;
    }

    public function getExteriorCooking(): ?bool
    {
        return $this->exterior_cooking;
    }

    public function setExteriorCooking(bool $exterior_cooking): self
    {
        $this->exterior_cooking = $exterior_cooking;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperty(): Collection
    {
        return $this->property;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->property->contains($property)) {
            $this->property[] = $property;
            $property->setRateHousing($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->property->contains($property)) {
            $this->property->removeElement($property);
            // set the owning side to null (unless already changed)
            if ($property->getRateHousing() === $this) {
                $property->setRateHousing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Images $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setRateHousing($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getRateHousing() === $this) {
                $image->setRateHousing(null);
            }
        }

        return $this;
    }

    public function getEnergyConsumption()
    {
        return $this->energyConsumption;
    }

    public function setEnergyConsumption($energyConsumption): self
    {
        $this->energyConsumption = $energyConsumption;

        return $this;
    }

    public function getWall(): ?Wall
    {
        return $this->wall;
    }

    public function setWall(?Wall $wall): self
    {
        $this->wall = $wall;

        return $this;
    }

    public function getGround(): ?Ground
    {
        return $this->ground;
    }

    public function setGround(?Ground $ground): self
    {
        $this->ground = $ground;

        return $this;
    }

    public function getBalcony(): ?bool
    {
        return $this->balcony;
    }

    public function setBalcony(?bool $balcony): self
    {
        $this->balcony = $balcony;

        return $this;
    }

    public function getBuildingStructure(): ?BuildingStructure
    {
        return $this->buildingStructure;
    }

    public function setBuildingStructure(?BuildingStructure $buildingStructure): self
    {
        $this->buildingStructure = $buildingStructure;

        return $this;
    }

    public function getShopWindows(): ?int
    {
        return $this->shop_windows;
    }

    public function setShopWindows(?int $shop_windows): self
    {
        $this->shop_windows = $shop_windows;

        return $this;
    }

    public function getPlants(): ?int
    {
        return $this->plants;
    }

    public function setPlants(?int $plants): self
    {
        $this->plants = $plants;

        return $this;
    }

    public function getTypeLocal(): ?TypeLocal
    {
        return $this->type_local;
    }

    public function setTypeLocal(?TypeLocal $type_local): self
    {
        $this->type_local = $type_local;

        return $this;
    }

    public function getStays(): ?Stays
    {
        return $this->stays;
    }

    public function setStays(?Stays $stays): self
    {
        $this->stays = $stays;

        return $this;
    }

    public function getLocalGarageLocation(): ?LocalGarageLocation
    {
        return $this->local_garage_location;
    }

    public function setLocalGarageLocation(?LocalGarageLocation $local_garage_location): self
    {
        $this->local_garage_location = $local_garage_location;

        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getSmokeOutlet(): ?bool
    {
        return $this->smoke_outlet;
    }

    public function setSmokeOutlet(?bool $smoke_outlet): self
    {
        $this->smoke_outlet = $smoke_outlet;

        return $this;
    }

    public function getSecurityDoor(): ?bool
    {
        return $this->security_door;
    }

    public function setSecurityDoor(?bool $security_door): self
    {
        $this->security_door = $security_door;

        return $this;
    }

    public function getWarehouse(): ?bool
    {
        return $this->warehouse;
    }

    public function setWarehouse(?bool $warehouse): self
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    public function getEquippedKitchen(): ?bool
    {
        return $this->equipped_kitchen;
    }

    public function setEquippedKitchen(?bool $equipped_kitchen): self
    {
        $this->equipped_kitchen = $equipped_kitchen;

        return $this;
    }

    public function getCorner(): ?bool
    {
        return $this->corner;
    }

    public function setCorner(?bool $corner): self
    {
        $this->corner = $corner;

        return $this;
    }

    public function getClosedSecurityCircuit(): ?bool
    {
        return $this->closed_security_circuit;
    }

    public function setClosedSecurityCircuit(?bool $closed_security_circuit): self
    {
        $this->closed_security_circuit = $closed_security_circuit;

        return $this;
    }

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function setSize(?Size $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getTypeGarage(): ?TypeGarage
    {
        return $this->type_garage;
    }

    public function setTypeGarage(?TypeGarage $type_garage): self
    {
        $this->type_garage = $type_garage;

        return $this;
    }

    public function getTypeStorageRoom(): ?TypeStorageRoom
    {
        return $this->type_storage_room;
    }

    public function setTypeStorageRoom(?TypeStorageRoom $type_storage_room): self
    {
        $this->type_storage_room = $type_storage_room;

        return $this;
    }

    public function getAccesibleTwentyFourHours(): ?bool
    {
        return $this->accesible_twenty_four_hours;
    }

    public function setAccesibleTwentyFourHours(?bool $accesible_twenty_four_hours): self
    {
        $this->accesible_twenty_four_hours = $accesible_twenty_four_hours;

        return $this;
    }

    public function getLoadingUnloadingArea(): ?bool
    {
        return $this->loading_unloading_area;
    }

    public function setLoadingUnloadingArea(?bool $loading_unloading_area): self
    {
        $this->loading_unloading_area = $loading_unloading_area;

        return $this;
    }

    public function getStorageRoomLocation(): ?StorageRoomLocation
    {
        return $this->storage_room_location;
    }

    public function setStorageRoomLocation(?StorageRoomLocation $storage_room_location): self
    {
        $this->storage_room_location = $storage_room_location;

        return $this;
    }

}
