<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="clientProjects")
     */
    private $teamClient;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="teamProjects")
     */
    private $productionTeam;

    /**
     * @ORM\ManyToOne(targetEntity=Budget::class, inversedBy="projects")
     */
    private $projectBudget;

    /**
     * @ORM\OneToMany(targetEntity=Fact::class, mappedBy="project")
     */
    private $projectFacts;

    /**
     * @ORM\OneToMany(targetEntity=Risk::class, mappedBy="project")
     */
    private $projectRisks;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archiveProject;

    /**
     * @ORM\ManyToOne(targetEntity=Portfolio::class, inversedBy="projectsPortfolio")
     */
    private $portfolio;

    public function __construct()
    {
        $this->projectFacts = new ArrayCollection();
        $this->projectRisks = new ArrayCollection();
    }

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

    public function getTeamClient(): ?Team
    {
        return $this->teamClient;
    }

    public function setTeamClient(?Team $teamClient): self
    {
        $this->teamClient = $teamClient;

        return $this;
    }

    public function getProductionTeam(): ?Team
    {
        return $this->productionTeam;
    }

    public function setProductionTeam(?Team $productionTeam): self
    {
        $this->productionTeam = $productionTeam;

        return $this;
    }

    public function getProjectBudget(): ?Budget
    {
        return $this->projectBudget;
    }

    public function setProjectBudget(?Budget $projectBudget): self
    {
        $this->projectBudget = $projectBudget;

        return $this;
    }

    /**
     * @return Collection|Fact[]
     */
    public function getProjectFacts(): Collection
    {
        return $this->projectFacts;
    }

    public function addProjectFact(Fact $projectFact): self
    {
        if (!$this->projectFacts->contains($projectFact)) {
            $this->projectFacts[] = $projectFact;
            $projectFact->setProject($this);
        }

        return $this;
    }

    public function removeProjectFact(Fact $projectFact): self
    {
        if ($this->projectFacts->removeElement($projectFact)) {
            // set the owning side to null (unless already changed)
            if ($projectFact->getProject() === $this) {
                $projectFact->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Risk[]
     */
    public function getProjectRisks(): Collection
    {
        return $this->projectRisks;
    }

    public function addProjectRisk(Risk $projectRisk): self
    {
        if (!$this->projectRisks->contains($projectRisk)) {
            $this->projectRisks[] = $projectRisk;
            $projectRisk->setProject($this);
        }

        return $this;
    }

    public function removeProjectRisk(Risk $projectRisk): self
    {
        if ($this->projectRisks->removeElement($projectRisk)) {
            // set the owning side to null (unless already changed)
            if ($projectRisk->getProject() === $this) {
                $projectRisk->setProject(null);
            }
        }

        return $this;
    }

    public function getArchiveProject(): ?bool
    {
        return $this->archiveProject;
    }

    public function setArchiveProject(bool $archiveProject): self
    {
        $this->archiveProject = $archiveProject;

        return $this;
    }

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolio $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }
}
