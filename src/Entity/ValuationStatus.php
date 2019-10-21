<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ValuationStatusRepository")
 */
class ValuationStatus
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
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="bathroomState")
     */
    private $bathroom_state;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="beenCooking")
     */
    private $been_cooking;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="windowsState")
     */
    private $windows_state;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="beenWalls")
     */
    private $been_walls;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="doorsState")
     */
    private $doors_state;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RateHousing", mappedBy="groundState")
     */
    private $ground_state;

    public function __construct()
    {
        $this->bathroom_state = new ArrayCollection();
        $this->been_cooking = new ArrayCollection();
        $this->windows_state = new ArrayCollection();
        $this->been_walls = new ArrayCollection();
        $this->doors_state = new ArrayCollection();
        $this->ground_state = new ArrayCollection();
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
    public function getBathroomState(): Collection
    {
        return $this->bathroom_state;
    }

    public function addBathroomState(RateHousing $bathroomState): self
    {
        if (!$this->bathroom_state->contains($bathroomState)) {
            $this->bathroom_state[] = $bathroomState;
            $bathroomState->setBathroomState($this);
        }

        return $this;
    }

    public function removeBathroomState(RateHousing $bathroomState): self
    {
        if ($this->bathroom_state->contains($bathroomState)) {
            $this->bathroom_state->removeElement($bathroomState);
            // set the owning side to null (unless already changed)
            if ($bathroomState->getBathroomState() === $this) {
                $bathroomState->setBathroomState(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RateHousing[]
     */
    public function getBeenCooking(): Collection
    {
        return $this->been_cooking;
    }

    public function addBeenCooking(RateHousing $beenCooking): self
    {
        if (!$this->been_cooking->contains($beenCooking)) {
            $this->been_cooking[] = $beenCooking;
            $beenCooking->setBeenCooking($this);
        }

        return $this;
    }

    public function removeBeenCooking(RateHousing $beenCooking): self
    {
        if ($this->been_cooking->contains($beenCooking)) {
            $this->been_cooking->removeElement($beenCooking);
            // set the owning side to null (unless already changed)
            if ($beenCooking->getBeenCooking() === $this) {
                $beenCooking->setBeenCooking(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RateHousing[]
     */
    public function getWindowsState(): Collection
    {
        return $this->windows_state;
    }

    public function addWindowsState(RateHousing $windowsState): self
    {
        if (!$this->windows_state->contains($windowsState)) {
            $this->windows_state[] = $windowsState;
            $windowsState->setWindowsState($this);
        }

        return $this;
    }

    public function removeWindowsState(RateHousing $windowsState): self
    {
        if ($this->windows_state->contains($windowsState)) {
            $this->windows_state->removeElement($windowsState);
            // set the owning side to null (unless already changed)
            if ($windowsState->getWindowsState() === $this) {
                $windowsState->setWindowsState(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RateHousing[]
     */
    public function getBeenWalls(): Collection
    {
        return $this->been_walls;
    }

    public function addBeenWall(RateHousing $beenWall): self
    {
        if (!$this->been_walls->contains($beenWall)) {
            $this->been_walls[] = $beenWall;
            $beenWall->setBeenWalls($this);
        }

        return $this;
    }

    public function removeBeenWall(RateHousing $beenWall): self
    {
        if ($this->been_walls->contains($beenWall)) {
            $this->been_walls->removeElement($beenWall);
            // set the owning side to null (unless already changed)
            if ($beenWall->getBeenWalls() === $this) {
                $beenWall->setBeenWalls(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RateHousing[]
     */
    public function getDoorsState(): Collection
    {
        return $this->doors_state;
    }

    public function addDoorsState(RateHousing $doorsState): self
    {
        if (!$this->doors_state->contains($doorsState)) {
            $this->doors_state[] = $doorsState;
            $doorsState->setDoorsState($this);
        }

        return $this;
    }

    public function removeDoorsState(RateHousing $doorsState): self
    {
        if ($this->doors_state->contains($doorsState)) {
            $this->doors_state->removeElement($doorsState);
            // set the owning side to null (unless already changed)
            if ($doorsState->getDoorsState() === $this) {
                $doorsState->setDoorsState(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RateHousing[]
     */
    public function getGroundState(): Collection
    {
        return $this->ground_state;
    }

    public function addGroundState(RateHousing $groundState): self
    {
        if (!$this->ground_state->contains($groundState)) {
            $this->ground_state[] = $groundState;
            $groundState->setGroundState($this);
        }

        return $this;
    }

    public function removeGroundState(RateHousing $groundState): self
    {
        if ($this->ground_state->contains($groundState)) {
            $this->ground_state->removeElement($groundState);
            // set the owning side to null (unless already changed)
            if ($groundState->getGroundState() === $this) {
                $groundState->setGroundState(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->name;
    }
}
