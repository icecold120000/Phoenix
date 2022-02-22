<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
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
        }
        $manager->flush();
    }
}
