<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="news")
     */
    private $commercial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $portal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $floor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NoteNew", mappedBy="new", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $noteNews;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reason", inversedBy="news")
     */
    private $reason;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Street", inversedBy="news")
     */
    private $street;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\RateHousing", mappedBy="new", cascade={"persist", "remove"})
     */
    private $rate_housing;

    /**
     * @ORM\Column(type="date")
     */
    private $created;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="boolean")
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Historical", inversedBy="news")
     */
    private $historical;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $sale_price;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $sale_date;

    public function __construct()
    {
        $this->noteNews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

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

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPortal(): ?string
    {
        return $this->portal;
    }

    public function setPortal(string $portal): self
    {
        $this->portal = $portal;

        return $this;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(string $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * @return Collection|NoteNew[]
     */
    public function getNoteNews(): Collection
    {
        return $this->noteNews;
    }

    public function addNoteNews(NoteNew $noteNews): self
    {
        if (!$this->noteNews->contains($noteNews)) {
            $this->noteNews[] = $noteNews;
            $noteNews->setNew($this);
        }

        return $this;
    }

    public function removeNoteNews(NoteNew $noteNews): self
    {
        if ($this->noteNews->contains($noteNews)) {
            $this->noteNews->removeElement($noteNews);
            // set the owning side to null (unless already changed)
            if ($noteNews->getNew() === $this) {
                $noteNews->setNew(null);
            }
        }

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

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->first_name . ' ' . $this->getPortal();
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

    public function getRateHousing(): ?RateHousing
    {
        return $this->rate_housing;
    }

    public function setRateHousing(?RateHousing $rate_housing): self
    {
        $this->rate_housing = $rate_housing;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): self
    {
        $this->state = $state;

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

    public function getSalePrice(): ?int
    {
        return $this->sale_price;
    }

    public function setSalePrice(?int $sale_price): self
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    public function getSaleDate(): ?\DateTimeInterface
    {
        return $this->sale_date;
    }

    public function setSaleDate(?\DateTimeInterface $sale_date): self
    {
        $this->sale_date = $sale_date;

        return $this;
    }

}
