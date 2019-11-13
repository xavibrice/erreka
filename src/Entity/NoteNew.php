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
     * @ORM\Column(type="date")
     */
    private $next_call;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="note_new")
     */
    private $property;

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

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return (string)$this->getNextCall()->format('d-m-Y');
    }


    public function getNextCall(): ?\DateTimeInterface
    {
        return $this->next_call;
    }

    public function setNextCall(\DateTimeInterface $next_call): self
    {
        $this->next_call = $next_call;

        return $this;
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
}
