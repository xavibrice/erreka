<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProposalRepository")
 */
class Proposal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="proposals")
     */
    private $property;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="proposals")
     */
    private $client;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $agree;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $contract;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $scriptures;

    /**
     * @ORM\Column(type="date")
     */
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getAgree(): ?bool
    {
        return $this->agree;
    }

    public function setAgree(?bool $agree): self
    {
        $this->agree = $agree;

        return $this;
    }

    public function getContract(): ?\DateTimeInterface
    {
        return $this->contract;
    }

    public function setContract(?\DateTimeInterface $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    public function getScriptures(): ?\DateTimeInterface
    {
        return $this->scriptures;
    }

    public function setScriptures(?\DateTimeInterface $scriptures): self
    {
        $this->scriptures = $scriptures;

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
}
