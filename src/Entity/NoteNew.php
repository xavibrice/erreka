<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteNewRepository")
 */
class NoteNew
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
     * @ORM\ManyToOne(targetEntity="App\Entity\News", inversedBy="noteNews")
     */
    private $new;

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

    public function getNew(): ?News
    {
        return $this->new;
    }

    public function setNew(?News $new): self
    {
        $this->new = $new;

        return $this;
    }
}
