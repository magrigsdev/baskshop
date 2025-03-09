<?php

namespace App\Tests;

use App\Entity\Users;
use App\Services\UsersServices;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Exception;
class UsersServicesTest extends KernelTestCase
{
    private $entityManager;
    private $usersRepository;
    private $projectDir;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $container = static::getContainer();
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->usersRepository = $this->entityManager->getRepository(Users::class);
        $this->projectDir = $container->getParameter('kernel.project_dir');
    }

    protected function tearDown(): void
    {
        $users = $this->usersRepository->findAll();
        foreach ($users as $user) {
            $this->entityManager->remove($user);
        }
        $this->entityManager->flush();
        parent::tearDown();
    }

    public function testGetusers(): void
    {
        $json = $this->projectDir."/var/json/users.json";
        if (!file_exists($json)){
            throw new Exception('File not found', 1);
        }
        $usersservices = new UsersServices($this->entityManager, $this->projectDir);
        $users = $usersservices->getUsersFromFile($json);
        //dump($users);
        $this->assertNotEmpty($users, 'array of users');
    }

    public function testPutusers(): void
    {
        $json = $this->projectDir.'/var/json/users.json';
        if (!file_exists($json)){
            throw new Exception('File not found', 1);
        }
        $usersservices = new UsersServices($this->entityManager, $this->projectDir);
        $users = $usersservices->getUsersFromFile($json);

        dump($users);
        $putusers = $usersservices->putUsersIntoDatabase($users);
        $this->assertNotFalse($putusers);
    } 
}
