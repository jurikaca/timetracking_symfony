<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeRepository")
 */
class Time
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_finished;

    /**
     * @ORM\Column(type="bigint")
     */
    private $time_tracked;

    /**
     * @ORM\Column(type="time")
     */
    private $time_tracked_formatted;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDateFinished(): ?\DateTimeInterface
    {
        return $this->date_finished;
    }

    public function setDateFinished(\DateTimeInterface $date_finished): self
    {
        $this->date_finished = $date_finished;

        return $this;
    }

    public function getTimeTracked(): ?int
    {
        return $this->time_tracked;
    }

    public function setTimeTracked(int $time_tracked): self
    {
        $this->time_tracked = $time_tracked;

        return $this;
    }

    public function getTimeTrackedFormatted(): ?\DateTimeInterface
    {
        return $this->time_tracked_formatted;
    }

    public function setTimeTrackedFormatted(\DateTimeInterface $time_tracked_formatted): self
    {
        $this->time_tracked_formatted = $time_tracked_formatted;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
