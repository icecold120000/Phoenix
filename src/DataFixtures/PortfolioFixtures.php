<?php

namespace App\DataFixtures;

use App\Entity\Portfolio;
use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PortfolioFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var User $teamLeader */
        $teamLeader = $this->getReference('user_4');

        /** @var Project $projet1 */
        $projet1 = $this->getReference('project_4');

        /** @var Project $projet2 */
        $projet2 = $this->getReference('project_2');

        /** @var Project $projet3 */
        $projet3 = $this->getReference('project_6');

        $portfolio = new Portfolio();
        $portfolio
            ->setNamePortfolio('Banana store')
            ->setResponsablePortfolio($teamLeader)
            ->addProjectsPortfolio($projet1)
            ->addProjectsPortfolio($projet2)
            ->addProjectsPortfolio($projet3)
        ;
        $manager->persist($portfolio);

        /** @var User $teamLeader */
        $teamLeader = $this->getReference('user_6');

        /** @var Project $projet1 */
        $projet1 = $this->getReference('project_1');

        /** @var Project $projet2 */
        $projet2 = $this->getReference('project_3');

        /** @var Project $projet3 */
        $projet3 = $this->getReference('project_9');

        $portfolio2 = new Portfolio();
        $portfolio2
            ->setNamePortfolio('reservation sandwich')
            ->setResponsablePortfolio($teamLeader)
            ->addProjectsPortfolio($projet1)
            ->addProjectsPortfolio($projet2)
            ->addProjectsPortfolio($projet3)
        ;
        $manager->persist($portfolio2);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
