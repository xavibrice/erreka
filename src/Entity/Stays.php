<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StaysRepository")
 */
class Stays
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
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="stays")
     */
    private $rateHousings;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="stays")
     */
    private $clients;

    public function __construct()
    {
        $this->rateHousings = new ArrayCollection();
        $this->clients = new ArrayCollection();
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
     * @return Collection|RateHousing[]
     */
    public function getRateHousings(): Collection
    {
        return $this->rateHousings;
    }

    public function addRateHousing(RateHousing $rateHousing): self
    {
        if (!$this->rateHousings->contains($rateHousing)) {
            $this->rateHousings[] = $rateHousing;
            $rateHousing->setStays($this);
        }

        return $this;
    }

    public function removeRateHousing(RateHousing $rateHousing): self
    {
        if ($this->rateHousings->contains($rateHousing)) {
            $this->rateHousings->removeElement($rateHousing);
            // set the owning side to null (unless already changed)
            if ($rateHousing->getStays() === $this) {
                $rateHousing->setStays(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setStays($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getStays() === $this) {
                $client->setStays(null);
            }
        }

        return $this;
    }
}
