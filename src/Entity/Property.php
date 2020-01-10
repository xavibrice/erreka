<?php

namespace App\Entity;

use App\Service\UploaderHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 */
class Property
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
    private $full_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Street", inversedBy="properties")
     */
    private $street;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reason", inversedBy="properties")
     */
    private $reason;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeProperty", inversedBy="property")
     */
    private $typeProperty;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     */
    private $commercial;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PropertyReduction", mappedBy="property", cascade={"persist"})
     */
    private $propertyReductions;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="date")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $portal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $floor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NoteNew", mappedBy="property")
     */
    private $note_new;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Visit", mappedBy="property")
     */
    private $visits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RateHousing", inversedBy="property")
     */
    private $rateHousing;

    /**
     * @ORM\Column(type="guid")
     */
    private $reference;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offered", mappedBy="property")
     */
    private $offereds;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Historical", inversedBy="property")
     */
    private $historical;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Charge", cascade={"persist", "remove"}, mappedBy="property")
     */
    private $charge;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposal", mappedBy="property")
     */
    private $proposals;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    public function __construct()
    {
        $this->propertyReductions = new ArrayCollection();
        $this->note_new = new ArrayCollection();
        $this->visits = new ArrayCollection();
        $this->offereds = new ArrayCollection();
        $this->proposals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(?string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

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

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStreet(): ?Street
    {
        return $this->street;
    }

    public function setStreet(?Street $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getReason(): ?Reason
    {
        return $this->reason;
    }

    public function setReason(?Reason $reason): self
    {
        $this->reason = $reason;

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

    public function getCommercial(): ?User
    {
        return $this->commercial;
    }

    public function setCommercial(?User $commercial): self
    {
        $this->commercial = $commercial;

        return $this;
    }

    /**
     * @return Collection|PropertyReduction[]
     */
    public function getPropertyReductions(): Collection
    {
        return $this->propertyReductions;
    }

    public function addPropertyReduction(PropertyReduction $propertyReduction): self
    {
        if (!$this->propertyReductions->contains($propertyReduction)) {
            $this->propertyReductions[] = $propertyReduction;
            $propertyReduction->setProperty($this);
        }

        return $this;
    }

    public function removePropertyReduction(PropertyReduction $propertyReduction): self
    {
        if ($this->propertyReductions->contains($propertyReduction)) {
            $this->propertyReductions->removeElement($propertyReduction);
            // set the owning side to null (unless already changed)
            if ($propertyReduction->getProperty() === $this) {
                $propertyReduction->setProperty(null);
            }
        }

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

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

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getPortal(): ?string
    {
        return $this->portal;
    }

    public function setPortal(?string $portal): self
    {
        $this->portal = $portal;

        return $this;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(?string $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * @return Collection|NoteNew[]
     */
    public function getNoteNew(): Collection
    {
        return $this->note_new;
    }

    public function addNoteNew(NoteNew $noteNew): self
    {
        if (!$this->note_new->contains($noteNew)) {
            $this->note_new[] = $noteNew;
            $noteNew->setProperty($this);
        }

        return $this;
    }

    public function removeNoteNew(NoteNew $noteNew): self
    {
        if ($this->note_new->contains($noteNew)) {
            $this->note_new->removeElement($noteNew);
            // set the owning side to null (unless already changed)
            if ($noteNew->getProperty() === $this) {
                $noteNew->setProperty(null);
            }
        }

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->street . ' Nº ' . $this->portal . ' Piso ' . $this->floor;
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
            $visit->setProperty($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): self
    {
        if ($this->visits->contains($visit)) {
            $this->visits->removeElement($visit);
            // set the owning side to null (unless already changed)
            if ($visit->getProperty() === $this) {
                $visit->setProperty(null);
            }
        }

        return $this;
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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
            $offered->setProperty($this);
        }

        return $this;
    }

    public function removeOffered(Offered $offered): self
    {
        if ($this->offereds->contains($offered)) {
            $this->offereds->removeElement($offered);
            // set the owning side to null (unless already changed)
            if ($offered->getProperty() === $this) {
                $offered->setProperty(null);
            }
        }

        return $this;
    }

    public function getHistorical(): ?Historical
    {
        return $this->historical;
    }

    public function setHistorical(?Historical $historical): self
    {
        $this->historical = $historical;

        return $this;
    }

    public function getCharge(): ?Charge
    {
        return $this->charge;
    }

    public function setCharge(?Charge $charge): self
    {
        $this->charge = $charge;

        return $this;
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
            $proposal->setProperty($this);
        }

        return $this;
    }

    public function removeProposal(Proposal $proposal): self
    {
        if ($this->proposals->contains($proposal)) {
            $this->proposals->removeElement($proposal);
            // set the owning side to null (unless already changed)
            if ($proposal->getProperty() === $this) {
                $proposal->setProperty(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
