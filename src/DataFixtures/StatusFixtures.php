<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $status1 = new Status();
        $status1->setName('Prévu')
            ->setSlug('prevu')
            ->setValue(0)
            ->setColorStatus('red')
        ;

        $manager->persist($status1);
        $this->addReference('status_0',$status1);

        $status2 = new Status();
        $status2->setName('En cours')
            ->setSlug('en_cours')
            ->setValue(1)
            ->setColorStatus('orange')
        ;

        $manager->persist($status2);
        $this->addReference('status_1',$status2);

        $status3 = new Status();
        $status3->setName('Terminé')
            ->setSlug('termine')
            ->setValue(2)
            ->setColorStatus('green')
        ;

        $manager->persist($status3);
        $this->addReference('status_2',$status3);

        $manager->flush();
    }
}
