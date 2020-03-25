<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TitleBookingRepository")
 */
class TitleBooking
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
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="titleBooking")
     */
    private $booking;

    public function __construct()
    {
        $this->booking = new ArrayCollection();
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
     * @return Collection|Booking[]
     */
    public function getBooking(): Collection
    {
        return $this->booking;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->booking->contains($booking)) {
            $this->booking[] = $booking;
            $booking->setTitleBooking($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->booking->contains($booking)) {
            $this->booking->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getTitleBooking() === $this) {
                $booking->setTitleBooking(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->name;
    }

}
