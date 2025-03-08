<?php

namespace App\Tests\Users\Repository;

use App\Entity\Users;
use App\Enum\Roles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UsersRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $UsersRepository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $container = static::getContainer();
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->UsersRepository = $this->entityManager->getRepository(Users::class);
    }

    protected function tearDown(): void
    {
        $users = $this->UsersRepository->findAll();
        foreach ($users as $user) {
            $this->entityManager->remove($user);
        }
        $this->entityManager->flush();
        parent::tearDown();
    }

    public function testAddUser(): void
    {
        $user = new Users();
        $user->setAddress('657 rue du bois');
        $user->setCity('Benir');
        $user->setCountry('France');
        $user->setLastName('Banis');
        $user->setFirstName('yass');
        $user->setRoles( "admin");
        $user->setPostalCode('66576');
        $user->setEmail('gh@ggg.com');
        $user->setPassword('hgy');
        // dump($user);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->assertNotNull($user->getId());
    }
}
