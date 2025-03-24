<?php

namespace App\Tests;

use App\Entity\Users;
use App\imports\Ingest;
use App\Services\UsersServices;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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

    public function testImportUsers(): void
    {
        $json = $this->projectDir.'/var/json/users.json';
        $ingest = new Ingest();
        $users = $ingest->getJson($json);

        // dump($users);
        $this->assertNotEmpty($users, 'array of users');
    }

    public function testSaveUsers(): void
    {
        $json = $this->projectDir.'/var/json/users.json';
        $ingest = new Ingest();
        $users = $ingest->getJson($json);
        $usersServices = new UsersServices($this->entityManager, $this->projectDir);
        $saveUsers = $usersServices->saveUsers($users);
        $this->assertNotFalse($saveUsers);
    }
}
