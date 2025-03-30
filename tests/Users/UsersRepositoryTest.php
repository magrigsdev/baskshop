<?php

namespace App\Tests\Users\Repository;

use App\Entity\Users;
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

    public function testAddBasket(): void
    {
        $user = new Users();
        $user->setAddress('65 rue de la paix');
        $user->setCity('Paris');
        $user->setCountry('France');
        $user->setEmail('elian@gmail.com');
        $user->setFirstName('Elian');
        $user->setLastName('Leroy');
        $user->setPostalCode('75000');
        $user->setRoles('admin');
        $user->setPassword('password');
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->assertNotNull($user->getId());
    }
}
