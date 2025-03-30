<?php

namespace App\Services;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;

class UsersServices
{
    private $projectDir;
    private $entityManager;
    private $usersRepository;

    public function __construct(EntityManagerInterface $entityManager, string $projectDir)
    {
        $this->entityManager = $entityManager;
        $this->usersRepository = $entityManager->getRepository(Users::class);
        $this->projectDir = $projectDir;
    }

   
}
