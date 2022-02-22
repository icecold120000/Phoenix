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
    private $nameMilstone;

    /**
     * @ORM\Column(type="integer")
     */
    private $valueMilstone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_required;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMilstone(): ?string
    {
        return $this->nameMilstone;
    }

    public function setNameMilstone(string $nameMilstone): self
    {
        $this->nameMilstone = $nameMilstone;

        return $this;
    }

    public function getValueMilstone(): ?int
    {
        return $this->valueMilstone;
    }

    public function setValueMilstone(int $valueMilstone): self
    {
        $this->valueMilstone = $valueMilstone;

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
