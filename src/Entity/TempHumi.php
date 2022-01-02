<?php

namespace App\Entity;

use App\Repository\TempHumiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempHumiRepository::class)
 */
class TempHumi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $temp;

    /**
     * @ORM\Column(type="float")
     */
    private $humi;

    /**
     * @ORM\Column(type="text")
     */
    private $user_push;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time_push;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemp(): ?float
    {
        return $this->temp;
    }

    public function setTemp(float $temp): self
    {
        $this->temp = $temp;

        return $this;
    }

    public function getHumi(): ?float
    {
        return $this->humi;
    }

    public function setHumi(float $humi): self
    {
        $this->humi = $humi;

        return $this;
    }

    public function getUserPush(): ?string
    {
        return $this->user_push;
    }

    public function setUserPush(string $user_push): self
    {
        $this->user_push = $user_push;

        return $this;
    }

    public function getTimePush(): ?\DateTimeInterface
    {
        return $this->time_push;
    }

    public function setTimePush(\DateTimeInterface $time_push): self
    {
        $this->time_push = $time_push;

        return $this;
    }
}
