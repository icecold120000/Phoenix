<?php

namespace App\Tests\Functional\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $userRepo = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepo->findOneBy(['email' => 'admin@gmail.com']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mes Projets :');
    }

    public function testNew(): void {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testEdit(): void {

    }

}
