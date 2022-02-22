<?php

namespace App\Entity;

use App\Repository\RiskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RiskRepository::class)
 */
class Risk
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
    private $nameRisk;

    /**
     * @ORM\Column(type="date")
     */
    private $identificationDateRisk;

    /**
     * @ORM\Column(type="date")
     */
    private $resolutionDateRisk;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $severityRisk;

    /**
     * @ORM\Column(type="integer")
     */
    private $probabilityRisk;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRisk(): ?string
    {
        return $this->nameRisk;
    }

    public function setNameRisk(string $nameRisk): self
    {
        $this->nameRisk = $nameRisk;

        return $this;
    }

    public function getIdentificationDateRisk(): ?\DateTimeInterface
    {
        return $this->identificationDateRisk;
    }

    public function setIdentificationDateRisk(\DateTimeInterface $identificationDateRisk): self
    {
        $this->identificationDateRisk = $identificationDateRisk;

        return $this;
    }

    public function getResolutionDateRisk(): ?\DateTimeInterface
    {
        return $this->resolutionDateRisk;
    }

    public function setResolutionDateRisk(\DateTimeInterface $resolutionDateRisk): self
    {
        $this->resolutionDateRisk = $resolutionDateRisk;

        return $this;
    }

    public function getSeverityRisk(): ?string
    {
        return $this->severityRisk;
    }

    public function setSeverityRisk(string $severityRisk): self
    {
        $this->severityRisk = $severityRisk;

        return $this;
    }

    public function getProbabilityRisk(): ?int
    {
        return $this->probabilityRisk;
    }

    public function setProbabilityRisk(int $probabilityRisk): self
    {
        $this->probabilityRisk = $probabilityRisk;

        return $this;
    }
}
