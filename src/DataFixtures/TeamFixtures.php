<?php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var User $teamLeader */
        $teamLeader = $this->getReference('user_1');

        /** @var User $teamMember1 */
        $teamMember1 = $this->getReference('user_2');

        /** @var User $teamMember2 */
        $teamMember2 = $this->getReference('user_3');

        $team1 = new Team();
        $team1
            ->setTeamName('Équipe 1')
            ->setTeamLeader($teamLeader)
            ->addTeamMember($teamMember1)
            ->addTeamMember($teamMember2)
        ;
        $manager->persist($team1);
        $this->addReference('team_1',$team1);

        /** @var User $teamLeader */
        $teamLeader = $this->getReference('user_5');

        /** @var User $teamMember1 */
        $teamMember1 = $this->getReference('user_6');

        /** @var User $teamMember2 */
        $teamMember2 = $this->getReference('user_7');

        $team2 = new Team();
        $team2
            ->setTeamName('Équipe 2')
            ->setTeamLeader($teamLeader)
            ->addTeamMember($teamMember1)
            ->addTeamMember($teamMember2)
        ;
        $manager->persist($team2);
        $this->addReference('team_2',$team2);

        /** @var User $teamLeader */
        $teamLeader = $this->getReference('user_4');

        /** @var User $teamMember1 */
        $teamMember1 = $this->getReference('user_1');

        /** @var User $teamMember2 */
        $teamMember2 = $this->getReference('user_8');

        $team3 = new Team();
        $team3
            ->setTeamName('Équipe 3')
            ->setTeamLeader($teamLeader)
            ->addTeamMember($teamMember1)
            ->addTeamMember($teamMember2)
        ;
        $manager->persist($team3);
        $this->addReference('team_3',$team3);

        /** @var User $teamLeader */
        $teamLeader = $this->getReference('user_9');

        /** @var User $teamMember1 */
        $teamMember1 = $this->getReference('user_2');

        /** @var User $teamMember2 */
        $teamMember2 = $this->getReference('user_0');

        $team4 = new Team();
        $team4
            ->setTeamName('Équipe 4')
            ->setTeamLeader($teamLeader)
            ->addTeamMember($teamMember1)
            ->addTeamMember($teamMember2)
        ;
        $manager->persist($team4);
        $this->addReference('team_4',$team4);


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
