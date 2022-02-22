<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nameProject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $descriptionProject;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $startedAt;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $endedAt;

    /**
     * @ORM\Column(type="date")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeProject;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProject(): ?string
    {
        return $this->nameProject;
    }

    public function setNameProject(string $nameProject): self
    {
        $this->nameProject = $nameProject;

        return $this;
    }

    public function getDescriptionProject(): ?string
    {
        return $this->descriptionProject;
    }

    public function setDescriptionProject(?string $descriptionProject): self
    {
        $this->descriptionProject = $descriptionProject;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->endedAt;
    }

    public function setEndedAt(\DateTimeInterface $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * ORM\PrePersist()
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();

    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCodeProject(): ?string
    {
        return $this->codeProject;
    }

    public function setCodeProject(string $codeProject): self
    {
        $this->codeProject = $codeProject;

        return $this;
    }
}
