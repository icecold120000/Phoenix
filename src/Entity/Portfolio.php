<?php

namespace App\Entity;

use App\Repository\PortfolioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PortfolioRepository::class)
 */
class Portfolio
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
    private $namePortfolio;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="portfolios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $responsablePortfolio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamePortfolio(): ?string
    {
        return $this->namePortfolio;
    }

    public function setNamePortfolio(string $namePortfolio): self
    {
        $this->namePortfolio = $namePortfolio;

        return $this;
    }

    public function getResponsablePortfolio(): ?User
    {
        return $this->responsablePortfolio;
    }

    public function setResponsablePortfolio(?User $responsablePortfolio): self
    {
        $this->responsablePortfolio = $responsablePortfolio;

        return $this;
    }
}
