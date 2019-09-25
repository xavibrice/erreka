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
     * @ORM\OneToMany(targetEntity="App\Entity\News", mappedBy="zone")
     */
    private $news;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Street", mappedBy="zone", cascade={"persist"}, orphanRemoval=true)
     * @Assert\NotBlank()
     */
    private $streets;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->streets = new ArrayCollection();
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

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->name;
    }

    /**
     * @return Collection|News[]
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): self
    {
        if (!$this->news->contains($news)) {
            $this->news[] = $news;
            $news->setZone($this);
        }

        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->contains($news)) {
            $this->news->removeElement($news);
            // set the owning side to null (unless already changed)
            if ($news->getZone() === $this) {
                $news->setZone(null);
            }
        }

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

}
