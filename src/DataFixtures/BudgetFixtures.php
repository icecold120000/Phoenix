<?php

namespace App\DataFixtures;

use App\Entity\Budget;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BudgetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i= 0; $i < 5;$i++) {

            $budget= new Budget();
            $budget
                ->setInitialBudget(random_int(1000,8000))
                ->setBudgetUsed(random_int(1000,8000))
                ->setQuantityLeftBudget(random_int(1000,10000))
            ;

            $manager->persist($budget);
            $this->addReference('budget_'.$i,$budget);
        }

        $manager->flush();
    }
}
