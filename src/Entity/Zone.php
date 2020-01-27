<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 */
class Zone
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Street", mappedBy="zone", cascade={"persist"})
     */
    private $streets;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency", inversedBy="zone")
     */
    private $agency;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="zoneOne")
     */
    private $clientsOne;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="zoneTwo")
     */
    private $clientsTwo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="zoneThree")
     */
    private $clientsThree;


    public function __construct()
    {
        $this->streets = new ArrayCollection();
        $this->clientsOne = new ArrayCollection();
        $this->clientsTwo = new ArrayCollection();
        $this->clientsThree = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Street[]
     */
    public function getStreets(): Collection
    {
        return $this->streets;
    }

    public function addStreet(Street $street): self
    {
        if (!$this->streets->contains($street)) {
            $this->streets[] = $street;
            $street->setZone($this);
        }

        return $this;
    }

    public function removeStreet(Street $street): self
    {
        if ($this->streets->contains($street)) {
            $this->streets->removeElement($street);
            // set the owning side to null (unless already changed)
            if ($street->getZone() === $this) {
                $street->setZone(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->name;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClientsOne(): Collection
    {
        return $this->clientsOne;
    }

    public function addClientsOne(Client $clientsOne): self
    {
        if (!$this->clientsOne->contains($clientsOne)) {
            $this->clientsOne[] = $clientsOne;
            $clientsOne->setZoneOne($this);
        }

        return $this;
    }

    public function removeClientsOne(Client $clientsOne): self
    {
        if ($this->clientsOne->contains($clientsOne)) {
            $this->clientsOne->removeElement($clientsOne);
            // set the owning side to null (unless already changed)
            if ($clientsOne->getZoneOne() === $this) {
                $clientsOne->setZoneOne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClientsTwo(): Collection
    {
        return $this->clientsTwo;
    }

    public function addClientsTwo(Client $clientsTwo): self
    {
        if (!$this->clientsTwo->contains($clientsTwo)) {
            $this->clientsTwo[] = $clientsTwo;
            $clientsTwo->setZoneTwo($this);
        }

        return $this;
    }

    public function removeClientsTwo(Client $clientsTwo): self
    {
        if ($this->clientsTwo->contains($clientsTwo)) {
            $this->clientsTwo->removeElement($clientsTwo);
            // set the owning side to null (unless already changed)
            if ($clientsTwo->getZoneTwo() === $this) {
                $clientsTwo->setZoneTwo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClientsThree(): Collection
    {
        return $this->clientsThree;
    }

    public function addClientsThree(Client $clientsThree): self
    {
        if (!$this->clientsThree->contains($clientsThree)) {
            $this->clientsThree[] = $clientsThree;
            $clientsThree->setZoneThree($this);
        }

        return $this;
    }

    public function removeClientsThree(Client $clientsThree): self
    {
        if ($this->clientsThree->contains($clientsThree)) {
            $this->clientsThree->removeElement($clientsThree);
            // set the owning side to null (unless already changed)
            if ($clientsThree->getZoneThree() === $this) {
                $clientsThree->setZoneThree(null);
            }
        }

        return $this;
    }

}
