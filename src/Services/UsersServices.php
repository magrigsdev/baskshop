<?php

namespace App\Services;

use App\Entity\Users;
use App\Messages\Error;
use Doctrine\ORM\EntityManagerInterface;

class UsersServices
{
    private $projectDir;
    private $entityManager;
    private $usersRepository;

    private Error $error;

    public function __construct(EntityManagerInterface $entityManager, string $projectDir)
    {
        $this->entityManager = $entityManager;
        $this->usersRepository = $entityManager->getRepository(Users::class);
        $this->projectDir = $projectDir;
    }

    public function getUsersFromFile(string $json_file): array
    {
        if (!file_exists($json_file)) {
            throw new \Exception($this->error::file_not_found($json_file));
        }
        $users_json = file_get_contents($json_file);
        if (false === $users_json) {
            throw new \Exception($this->error::file_failed_to_read($json_file));
        }
        $users = json_decode($users_json, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \Exception($this->error::json_invalid);
        }

        return $users;
    }

    public function putUsersIntoDatabase(array $users): bool
    {
        if (empty($users)) {
            throw new \Exception($this->error::array_empty('users'));
        }

        foreach ($users as $user) {
            $newuser = (new Users())
            ->setAddress($user['address'])
            ->setCity($user['city'])
            ->setCountry($user['country'])
            ->setEmail($user['email'])
            ->setFirstName($user['first_name'])
            ->setLastName($user['last_name'])
            ->setPassword($user['password'])
            ->setPostalCode($user['postal_code'])
            ->setRoles($user['role']);
            $this->entityManager->persist($newuser);
            $this->entityManager->flush();
        }

        return true;
    }
}
