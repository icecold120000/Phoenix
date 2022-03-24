<?php

namespace App\Entity;

use App\Repository\MilestoneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MilestoneRepository::class)
 */
class Milestone
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
    private ?string $nameMilestone;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $valueMilestone;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isRequired;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $dateObtained;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMilestone(): ?string
    {
        return $this->nameMilestone;
    }

    public function setNameMilestone(string $nameMilestone): self
    {
        $this->nameMilestone = $nameMilestone;

        return $this;
    }

    public function getValueMilestone(): ?int
    {
        return $this->valueMilestone;
    }

    public function setValueMilestone(int $valueMilestone): self
    {
        $this->valueMilestone = $valueMilestone;

        return $this;
    }

    public function getIsRequired(): ?bool
    {
        return $this->isRequired;
    }

    public function setIsRequired(bool $isRequired): self
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    public function getDateObtained(): ?\DateTimeInterface
    {
        return $this->dateObtained;
    }

    public function setDateObtained(\DateTimeInterface $dateObtained): self
    {
        $this->dateObtained = $dateObtained;

        return $this;
    }
}
