<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SituationRepository")
 */
class Situation
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
     * @ORM\OneToMany(targetEntity="App\Entity\News", mappedBy="situation")
     */
    private $news;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reason", mappedBy="situation", cascade={"persist"}, orphanRemoval=true)
     */
    private $reasons;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->reasons = new ArrayCollection();
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
            $news->setSituation($this);
        }

        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->contains($news)) {
            $this->news->removeElement($news);
            // set the owning side to null (unless already changed)
            if ($news->getSituation() === $this) {
                $news->setSituation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }

    /**
     * @return Collection|Reason[]
     */
    public function getReasons(): Collection
    {
        return $this->reasons;
    }

    public function addReason(Reason $reason): self
    {
        if (!$this->reasons->contains($reason)) {
            $this->reasons[] = $reason;
            $reason->setSituation($this);
        }

        return $this;
    }

    public function removeReason(Reason $reason): self
    {
        if ($this->reasons->contains($reason)) {
            $this->reasons->removeElement($reason);
            // set the owning side to null (unless already changed)
            if ($reason->getSituation() === $this) {
                $reason->setSituation(null);
            }
        }

        return $this;
    }
}
