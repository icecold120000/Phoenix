<?php

namespace App\DataFixtures;

use App\Entity\Budget;
use App\Entity\Project;
use App\DataFixtures\StatusFixtures;
use App\Entity\Status;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i=0;$i < 10; $i++){
            $nb = random_int(0,2);
            /** @var Status $status */
            $status = $this->getReference('status_'.$nb);

            /** @var Team $teamClient */
            $teamClient = $this->getReference('team_'.random_int(1,4));

            /** @var Team $teamProd */
            $teamProd = $this->getReference('team_'.random_int(1,4));

            /** @var Budget $budget */
            $budget = $this->getReference('budget'.random_int(0,5));

            $project = new Project();
            $project->setNameProject('project'.$i)
                ->setDescriptionProject('nidzojcznczidiez')
                ->setStartedAt(new \DateTime())
                ->setEndedAt(new \DateTime())
                ->setCreatedAt(new \DateTime())
                ->setCodeProject('projectS'.$i)
                ->setArchiveProject(false)
                ->setProjectBudget($budget)
                ->setProductionTeam($teamProd)
                ->setTeamClient($teamClient)
                ->setStatus($status)
            ;

            $manager->persist($project);
            $this->addReference('project_'.$i,$project);
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BudgetFixtures::class,
            StatusFixtures::class,
            TeamFixtures::class,
        ];
    }
}
