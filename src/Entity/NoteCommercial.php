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
     * @ORM\Column(type="string", length=255)
     */
    private $note;

    /**
     * @ORM\Column(type="date")
     */
    private $notice_data;

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

    public function getNoticeData(): ?\DateTimeInterface
    {
        return $this->notice_data;
    }

    public function setNoticeData(\DateTimeInterface $notice_data): self
    {
        $this->notice_data = $notice_data;

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
