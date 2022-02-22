<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Risk;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RiskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $severity = [
            "Sévère",
            "Critique",
            "Mineur",
            "Majeur"
        ];
        for ($i = 0; $i < 10; $i++) {
            $nb = random_int(0,9);
            /** @var Project $project */
            $project= $this->getReference('project_'.$nb);
            $risk = new Risk();
            $risk
                ->setNameRisk('risk '.$i)
                ->setIdentificationDateRisk(new \DateTime())
                ->setResolutionDateRisk(new \DateTime())
                ->setSeverityRisk($severity[random_int(0,3)])
                ->setProbabilityRisk(random_int(0,100))
                ->setProject($project)
            ;

            $manager->persist($risk);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProjectFixtures::class,
        ];
    }
}
