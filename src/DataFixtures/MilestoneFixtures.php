<?php

namespace App\DataFixtures;

use App\Entity\Milestone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MilestoneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $milestone = new Milestone();
            $milestone
                ->setNameMilestone('milestone '.$i)
                ->setValueMilestone($i)
                ->setIsRequired(true)
            ;
            $manager->persist($milestone);
            $this->addReference('milestone_'.$i,$milestone);
        }


        $manager->flush();
    }
}
