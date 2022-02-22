<?php

namespace App\Entity;

use App\Repository\FactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactRepository::class)
 */
class Fact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameFact;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionFact;

    /**
     * @ORM\ManyToOne(targetEntity=Milestone::class)
     */
    private $milestoneFact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFact(): ?\DateTimeInterface
    {
        return $this->dateFact;
    }

    public function setDateFact(\DateTimeInterface $dateFact): self
    {
        $this->dateFact = $dateFact;

        return $this;
    }

    public function getNameFact(): ?string
    {
        return $this->nameFact;
    }

    public function setNameFact(string $nameFact): self
    {
        $this->nameFact = $nameFact;

        return $this;
    }

    public function getDescriptionFact(): ?string
    {
        return $this->descriptionFact;
    }

    public function setDescriptionFact(string $descriptionFact): self
    {
        $this->descriptionFact = $descriptionFact;

        return $this;
    }

    public function getMilestoneFact(): ?Milestone
    {
        return $this->milestoneFact;
    }

    public function setMilestoneFact(?Milestone $milestoneFact): self
    {
        $this->milestoneFact = $milestoneFact;

        return $this;
    }
}
