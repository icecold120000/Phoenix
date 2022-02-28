<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i  < 10; $i++) {
            $user = new User();
            $user
                ->setFirstnameUser('firstname'.$i)
                ->setLastnameUser('lastname'.$i)
                ->setEmail('firstname'.$i.'@gmail.com')
                ->setPassword($this->hasher->hashPassword($user, 'test'))

            ;
            $manager->persist($user);
            $this->addReference('user_'.$i,$user);
        }

        $userAdmin = new User();
        $userAdmin
            ->setFirstnameUser('admin')
            ->setLastnameUser('admin')
            ->setEmail('admin@gmail.com')
            ->setPassword($this->hasher->hashPassword($userAdmin, 'admin'))

        ;
        $manager->persist($userAdmin);
        $this->addReference('user_admin_'.$i,$userAdmin);

        $manager->flush();
    }
}
