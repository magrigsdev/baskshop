<?php 

namespace App\Services;

use App\Entity\Users;
use App\Messages\Error;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
class UsersServices
{
    
    private $projectDir;
    private $entityManager;
    private $themeRepository;
    public function __construct(EntityManagerInterface $entityManager, string $projectDir)
    {
        $this->entityManager = $entityManager;
        $this->themeRepository = $entityManager->getRepository(Users::class);
        $this->projectDir = $projectDir;

    }
    public function getUsersFromFile(string $json_file): array
    {
        $error = new Error();
    
        if (!file_exists($json_file)) {
           throw new Exception($error::file_not_found($json_file));
        }
        $users_json = file_get_contents($json_file);
        if($users_json === false){
            throw new Exception($error::file_failed_to_read($json_file));
        }
        $users = json_decode($users_json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception($error::json_invalid);
        }

        return $users;
    }
    
}
