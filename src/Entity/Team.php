<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
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
    private $teamName;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="teams")
     */
    private $teamLeader;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="team")
     */
    private $teamMembers;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="teamParent")
     */
    private $team;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="team")
     */
    private $teamParent;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="teamClient")
     */
    private $clientProjects;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="productionTeam")
     */
    private $teamProjects;

    public function __construct()
    {
        $this->teamMembers = new ArrayCollection();
        $this->teamParent = new ArrayCollection();
        $this->clientProjects = new ArrayCollection();
        $this->teamProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): self
    {
        $this->teamName = $teamName;

        return $this;
    }

    public function getTeamLeader(): ?User
    {
        return $this->teamLeader;
    }

    public function setTeamLeader(?User $teamLeader): self
    {
        $this->teamLeader = $teamLeader;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getTeamMembers(): Collection
    {
        return $this->teamMembers;
    }

    public function addTeamMember(User $teamMember): self
    {
        if (!$this->teamMembers->contains($teamMember)) {
            $this->teamMembers[] = $teamMember;
            $teamMember->setTeam($this);
        }

        return $this;
    }

    public function removeTeamMember(User $teamMember): self
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            // set the owning side to null (unless already changed)
            if ($teamMember->getTeam() === $this) {
                $teamMember->setTeam(null);
            }
        }

        return $this;
    }

    public function getTeam(): ?self
    {
        return $this->team;
    }

    public function setTeam(?self $team): self
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getTeamParent(): Collection
    {
        return $this->teamParent;
    }

    public function addTeamParent(self $teamParent): self
    {
        if (!$this->teamParent->contains($teamParent)) {
            $this->teamParent[] = $teamParent;
            $teamParent->setTeam($this);
        }

        return $this;
    }

    public function removeTeamParent(self $teamParent): self
    {
        if ($this->teamParent->removeElement($teamParent)) {
            // set the owning side to null (unless already changed)
            if ($teamParent->getTeam() === $this) {
                $teamParent->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getClientProjects(): Collection
    {
        return $this->clientProjects;
    }

    public function addClientProject(Project $clientProjects): self
    {
        if (!$this->clientProjects->contains($clientProjects)) {
            $this->clientProjects[] = $clientProjects;
            $clientProjects->setTeamClient($this);
        }

        return $this;
    }

    public function removeProject(Project $clientProjects): self
    {
        if ($this->clientProjects->removeElement($clientProjects)) {
            // set the owning side to null (unless already changed)
            if ($clientProjects->getTeamClient() === $this) {
                $clientProjects->setTeamClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getTeamProjects(): Collection
    {
        return $this->teamProjects;
    }

    public function addTeamProject(Project $teamProject): self
    {
        if (!$this->teamProjects->contains($teamProject)) {
            $this->teamProjects[] = $teamProject;
            $teamProject->setProductionTeam($this);
        }

        return $this;
    }

    public function removeTeamProject(Project $teamProject): self
    {
        if ($this->teamProjects->removeElement($teamProject)) {
            // set the owning side to null (unless already changed)
            if ($teamProject->getProductionTeam() === $this) {
                $teamProject->setProductionTeam(null);
            }
        }

        return $this;
    }
}
