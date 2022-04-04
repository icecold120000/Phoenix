<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BudgetRepository::class)
 */
class Budget
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $initialBudget;

    /**
     * @ORM\Column(type="integer")
     */
    private $budgetUsed;

    /**
     * @ORM\Column(type="integer")
     * Un reste à faire
     */
    private $quantityLeftBudget;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="projectBudget", cascade={"persist"})
     */
    private $projects;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameBudget;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitialBudget(): ?int
    {
        return $this->initialBudget;
    }

    public function setInitialBudget(int $initialBudget): self
    {
        $this->initialBudget = $initialBudget;

        return $this;
    }

    public function getBudgetUsed(): ?int
    {
        return $this->budgetUsed;
    }

    public function setBudgetUsed(int $budgetUsed): self
    {
        $this->budgetUsed = $budgetUsed;

        return $this;
    }

    public function getQuantityLeftBudget(): ?int
    {
        return $this->quantityLeftBudget;
    }

    public function setQuantityLeftBudget(int $quantityLeftBudget): self
    {
        $this->quantityLeftBudget = $quantityLeftBudget;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setProjectBudget($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getProjectBudget() === $this) {
                $project->setProjectBudget(null);
            }
        }

        return $this;
    }

    public function getNameBudget(): ?string
    {
        return $this->nameBudget;
    }

    public function setNameBudget(string $nameBudget): self
    {
        $this->nameBudget = $nameBudget;

        return $this;
    }
}
