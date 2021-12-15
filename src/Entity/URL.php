<?php

namespace App\Entity;

use App\Repository\URLRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=URLRepository::class)
 * @UniqueEntity("urlString")
 */
class URL
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlString;

    /**
     * @ORM\OneToMany(targetEntity=UptimeResult::class, mappedBy="url")
     */
    private $uptimeResults;

    public function __construct()
    {
        $this->uptimeResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlString(): ?string
    {
        return $this->urlString;
    }

    public function setUrlString(string $urlString): self
    {
        $this->urlString = $urlString;

        return $this;
    }

    /**
     * @return Collection|UptimeResult[]
     */
    public function getUptimeResults(): Collection
    {
        return $this->uptimeResults;
    }

    public function addUptimeResult(UptimeResult $uptimeResult): self
    {
        if (!$this->uptimeResults->contains($uptimeResult)) {
            $this->uptimeResults[] = $uptimeResult;
            $uptimeResult->setUrl($this);
        }

        return $this;
    }

    public function removeUptimeResult(UptimeResult $uptimeResult): self
    {
        if ($this->uptimeResults->removeElement($uptimeResult)) {
            // set the owning side to null (unless already changed)
            if ($uptimeResult->getUrl() === $this) {
                $uptimeResult->setUrl(null);
            }
        }

        return $this;
    }
}
