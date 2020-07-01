<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferedRepository")
 */
class Offered
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="offereds")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Charge", inversedBy="offereds")
     */
    private $charge;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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
}
