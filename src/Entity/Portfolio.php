<?php

namespace App\Entity;

use App\Repository\PortfolioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="portfolio")
     */
    private $projectsPortfolio;

    public function __construct()
    {
        $this->projectsPortfolio = new ArrayCollection();
    }

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

    /**
     * @return Collection|Project[]
     */
    public function getProjectsPortfolio(): Collection
    {
        return $this->projectsPortfolio;
    }

    public function addProjectsPortfolio(Project $projectsPortfolio): self
    {
        if (!$this->projectsPortfolio->contains($projectsPortfolio)) {
            $this->projectsPortfolio[] = $projectsPortfolio;
            $projectsPortfolio->setPortfolio($this);
        }

        return $this;
    }

    public function removeProjectsPortfolio(Project $projectsPortfolio): self
    {
        if ($this->projectsPortfolio->removeElement($projectsPortfolio)) {
            // set the owning side to null (unless already changed)
            if ($projectsPortfolio->getPortfolio() === $this) {
                $projectsPortfolio->setPortfolio(null);
            }
        }

        return $this;
    }
}
