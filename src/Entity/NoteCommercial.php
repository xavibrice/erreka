<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteCommercialRepository")
 */
class NoteCommercial
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $note;

    /**
     * @ORM\Column(type="date")
     */
    private $notice_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="noteCommercials")
     */
    private $commercial;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNoticeDate(): ?\DateTimeInterface
    {
        return $this->notice_date;
    }

    public function setNoticeDate(\DateTimeInterface $notice_date): self
    {
        $this->notice_date = $notice_date;

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
}
