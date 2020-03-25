<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endAt = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
     */
    private $commercial;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TitleBooking", inversedBy="booking")
     */
    private $titleBooking;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LocationBooking", inversedBy="booking")
     */
    private $locationBooking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTime
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTime $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTime
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTime $endAt = null): self
    {
        $this->endAt = $endAt;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitleBooking(): ?TitleBooking
    {
        return $this->titleBooking;
    }

    public function setTitleBooking(?TitleBooking $titleBooking): self
    {
        $this->titleBooking = $titleBooking;

        return $this;
    }

    public function getLocationBooking(): ?LocationBooking
    {
        return $this->locationBooking;
    }

    public function setLocationBooking(?LocationBooking $locationBooking): self
    {
        $this->locationBooking = $locationBooking;

        return $this;
    }
}