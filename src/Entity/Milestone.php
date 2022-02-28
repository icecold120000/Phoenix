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
    private $nameMilestone;

    /**
     * @ORM\Column(type="integer")
     */
    private $valueMilestone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_required;

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
        return $this->is_required;
    }

    public function setIsRequired(bool $is_required): self
    {
        $this->is_required = $is_required;

        return $this;
    }
}
