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

    public function saveUsers(array $users): bool
    {
        if (empty($users)) {
            throw new \Exception('No users to insert');
        }

        foreach ($users as $user) {
            $newuser = (new Users())
            ->setAddress($user['address'])
            ->setCity($user['city'])
            ->setCountry($user['country'])
            ->setEmail($user['email'])
            ->setFirstName($user['firstName'])
            ->setLastName($user['lastName'])
            ->setPassword($user['password'])
            ->setPostalCode($user['postalCode'])
            ->setRoles($user['roles']);
            $this->entityManager->persist($newuser);
            $this->entityManager->flush();
        }

        return true;
    }
}
