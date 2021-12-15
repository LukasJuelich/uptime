<?php

namespace App\Entity;

use App\Repository\UptimeResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UptimeResultRepository::class)
 */
class UptimeResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $statusCode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=URL::class, inversedBy="uptimeResults")
     */
    private $url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    public function setStatusCode(string $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUrl(): ?URL
    {
        return $this->url;
    }

    public function setUrl(?URL $url): self
    {
        $this->url = $url;

        return $this;
    }
}
