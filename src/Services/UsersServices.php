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
            $new_user = new Users();
            $new_user->setAddress($user['address']);
            $new_user->setCity($user['city']);
            $new_user->setCountry($user['country']);
            $new_user->setEmail($user['email']);
            $new_user->setFirstName($user['firstName']);
            $new_user->setLastName($user['lastName']);
            $new_user->setPassword($user['password']);
            $new_user->setPostalCode($user['postalCode']);
            $new_user->setRoles($user['roles']);
            $this->entityManager->persist($new_user);
        }
        $this->entityManager->flush();
        $this->entityManager->clear();

        return true;
    }
}
