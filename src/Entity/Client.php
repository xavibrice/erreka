<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups("main")
     */
    private $full_name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
//     * @Groups("main")
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
    private $direct_garage;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visit", mappedBy="client", cascade={"remove"})
     */
    private $visits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clients")
     */
    private $commercial;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeProperty", inversedBy="clients")
     */
    private $typeProperty;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposal", mappedBy="client", cascade={"remove"})
     */
    private $proposals;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bedrooms", inversedBy="client")
     */
    private $bedrooms;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BuildingStructure", inversedBy="clients")
     */
    private $building_structure;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $income;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pets;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $balcony;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="clientsOne")
     */
    private $zoneOne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="clientsTwo")
     */
    private $zoneTwo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="clientsThree")
     */
    private $zoneThree;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offered", mappedBy="client")
     */
    private $offereds;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NoteClient", mappedBy="client")
     */
    private $noteClients;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="clients")
     */
    private $zone_four;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $nextCall;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sellOrRent;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nationality;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
        $this->proposals = new ArrayCollection();
        $this->offereds = new ArrayCollection();
        $this->noteClients = new ArrayCollection();
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

    public function getDirectGarage(): ?bool
    {
        return $this->direct_garage;
    }

    public function setDirectGarage(?bool $direct_garage): self
    {
        $this->direct_garage = $direct_garage;

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

    /**
     * @return Collection|Visit[]
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visit $visit): self
    {
        if (!$this->visits->contains($visit)) {
            $this->visits[] = $visit;
            $visit->setClient($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): self
    {
        if ($this->visits->contains($visit)) {
            $this->visits->removeElement($visit);
            // set the owning side to null (unless already changed)
            if ($visit->getClient() === $this) {
                $visit->setClient(null);
            }
        }

        return $this;
    }

    public function getCommercial(): ?User
    {
        return $this->commercial;
    }

    public function setCommercial(?User $commercial): self
    {
        $this->commercial = $commercial;

        return $this;
    }

    public function getTypeProperty(): ?TypeProperty
    {
        return $this->typeProperty;
    }

    public function setTypeProperty(?TypeProperty $typeProperty): self
    {
        $this->typeProperty = $typeProperty;

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->full_name . ' - ' . $this->mobile;
    }

    /**
     * @return Collection|Proposal[]
     */
    public function getProposals(): Collection
    {
        return $this->proposals;
    }

    public function addProposal(Proposal $proposal): self
    {
        if (!$this->proposals->contains($proposal)) {
            $this->proposals[] = $proposal;
            $proposal->setClient($this);
        }

        return $this;
    }

    public function removeProposal(Proposal $proposal): self
    {
        if ($this->proposals->contains($proposal)) {
            $this->proposals->removeElement($proposal);
            // set the owning side to null (unless already changed)
            if ($proposal->getClient() === $this) {
                $proposal->setClient(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBedrooms(): ?Bedrooms
    {
        return $this->bedrooms;
    }

    public function setBedrooms(?Bedrooms $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getBuildingStructure(): ?BuildingStructure
    {
        return $this->building_structure;
    }

    public function setBuildingStructure(?BuildingStructure $building_structure): self
    {
        $this->building_structure = $building_structure;

        return $this;
    }

    public function getIncome()
    {
        return $this->income;
    }

    public function setIncome($income): self
    {
        $this->income = $income;

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

    public function getBalcony(): ?bool
    {
        return $this->balcony;
    }

    public function setBalcony(bool $balcony): self
    {
        $this->balcony = $balcony;

        return $this;
    }

    public function getZoneOne(): ?Zone
    {
        return $this->zoneOne;
    }

    public function setZoneOne(?Zone $zoneOne): self
    {
        $this->zoneOne = $zoneOne;

        return $this;
    }

    public function getZoneTwo(): ?Zone
    {
        return $this->zoneTwo;
    }

    public function setZoneTwo(?Zone $zoneTwo): self
    {
        $this->zoneTwo = $zoneTwo;

        return $this;
    }

    public function getZoneThree(): ?Zone
    {
        return $this->zoneThree;
    }

    public function setZoneThree(?Zone $zoneThree): self
    {
        $this->zoneThree = $zoneThree;

        return $this;
    }

    /**
     * @return Collection|Offered[]
     */
    public function getOffereds(): Collection
    {
        return $this->offereds;
    }

    public function addOffered(Offered $offered): self
    {
        if (!$this->offereds->contains($offered)) {
            $this->offereds[] = $offered;
            $offered->setClient($this);
        }

        return $this;
    }

    public function removeOffered(Offered $offered): self
    {
        if ($this->offereds->contains($offered)) {
            $this->offereds->removeElement($offered);
            // set the owning side to null (unless already changed)
            if ($offered->getClient() === $this) {
                $offered->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NoteClient[]
     */
    public function getNoteClients(): Collection
    {
        return $this->noteClients;
    }

    public function addNoteClient(NoteClient $noteClient): self
    {
        if (!$this->noteClients->contains($noteClient)) {
            $this->noteClients[] = $noteClient;
            $noteClient->setClient($this);
        }

        return $this;
    }

    public function removeNoteClient(NoteClient $noteClient): self
    {
        if ($this->noteClients->contains($noteClient)) {
            $this->noteClients->removeElement($noteClient);
            // set the owning side to null (unless already changed)
            if ($noteClient->getClient() === $this) {
                $noteClient->setClient(null);
            }
        }

        return $this;
    }

    public function getZoneFour(): ?Zone
    {
        return $this->zone_four;
    }

    public function setZoneFour(?Zone $zone_four): self
    {
        $this->zone_four = $zone_four;

        return $this;
    }

    public function getNextCall(): ?\DateTimeInterface
    {
        return $this->nextCall;
    }

    public function setNextCall(?\DateTimeInterface $nextCall): self
    {
        $this->nextCall = $nextCall;

        return $this;
    }

    public function getSellOrRent(): ?bool
    {
        return $this->sellOrRent;
    }

    public function setSellOrRent(?bool $sellOrRent): self
    {
        $this->sellOrRent = $sellOrRent;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

}
