<?php

namespace App\Services;

use App\Entity\Baskets;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
class BasketsServices
{
    private $project_dir;
    private $entity_manager;
    private $baskets_repository;

    public function __construct(entityManagerInterface $entity_manager, string $project_dir)
    {
        $this->entity_manager = $entity_manager;
        $this->usersRepository = $entity_manager->getRepository(Baskets::class);
        $this->project_dir = $project_dir;
    }

    public function getBasketsFromFile(string $json_file): array
    {
        if (!file_exists($json_file)) {
            throw new Exception("File not exist " .$json_file);
        }
        $baskets_json = file_get_contents($json_file);
        if (false === $baskets_json) {
            throw new Exception( "File failed to read" .$json_file);
        }
        $baskets = json_decode($baskets_json, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new Exception("json not valid");
        }

        return $baskets;
    }

    public function putBasketsIntoDatabase(array $baskets): bool
    {
        if (empty($baskets)) {
            throw new Exception("No users to insert");
        }

        foreach ($baskets as $basket) {
            $new_basket = (new Baskets())
            ->setBrand($basket['brands'])
            ->setColor($basket['colors'])
            ->setName($basket['name'])
            ->setSize($basket['size']);

            $this->entity_manager->persist($new_basket);
            $this->entity_manager->flush();
        }

        return true;
    }

    private function convertColorsInColor(array $colors)
    {
        return implode(", ", $colors);
    }

}
