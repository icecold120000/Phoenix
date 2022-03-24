<?php

namespace App\DataFixtures;

use App\Entity\Fact;
use App\Entity\Milestone;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FactFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $nb = random_int(0,9);
            /** @var Project $project */
            $project= $this->getReference('project_'.$nb);
            /** @var Milestone $milestone */
            $milestone = $this->getReference('milestone_'.$nb);

            $fact = new Fact();
            $fact
                ->setNameFact('fact '.$i)
                ->setDateFact(new \DateTime())
                ->setDescriptionFact('random description')
                ->setMilestoneFact($milestone)
                ->setIsValidated(false)
                ->setProject($project)
            ;
            $manager->persist($fact);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            ProjectFixtures::class,
            MilestoneFixtures::class,
        ];
    }
}
