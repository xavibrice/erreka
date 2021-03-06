<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BuildingStructureRepository")
 */
class BuildingStructure
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
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="buildingStructure")
     */
    private $building_structure;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="building_structure")
     */
    private $clients;

    public function __construct()
    {
        $this->building_structure = new ArrayCollection();
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
    public function getBuildingStructure(): Collection
    {
        return $this->building_structure;
    }

    public function addBuildingStructure(RateHousing $buildingStructure): self
    {
        if (!$this->building_structure->contains($buildingStructure)) {
            $this->building_structure[] = $buildingStructure;
            $buildingStructure->setBuildingStructure($this);
        }

        return $this;
    }

    public function removeBuildingStructure(RateHousing $buildingStructure): self
    {
        if ($this->building_structure->contains($buildingStructure)) {
            $this->building_structure->removeElement($buildingStructure);
            // set the owning side to null (unless already changed)
            if ($buildingStructure->getBuildingStructure() === $this) {
                $buildingStructure->setBuildingStructure(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->name;
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
            $client->setBuildingStructure($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getBuildingStructure() === $this) {
                $client->setBuildingStructure(null);
            }
        }

        return $this;
    }
}
