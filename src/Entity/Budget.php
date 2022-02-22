<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
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
     */
    private $quantityLeftBudget;

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
}
