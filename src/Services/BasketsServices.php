<?php

namespace App\Services;

use App\Entity\Baskets;
use Doctrine\ORM\EntityManagerInterface;

class BasketsServices
{
    private $project_dir;
    private $entity_manager;
    private $baskets_repository;

    public function __construct(EntityManagerInterface $entity_manager, string $project_dir)
    {
        $this->entity_manager = $entity_manager;
        $this->baskets_repository = $entity_manager->getRepository(Baskets::class);
        $this->project_dir = $project_dir;
    }
    public function getBaskets(array $baskets): array
    {
        $baskets = [];
        foreach ($baskets as $basket) {
            $basket = new Baskets();
            $basket->setBrand($basket['brand']);
            $basket->setColor($basket['color']);
            $basket->setName($basket['name']);
            $basket->setSize($basket['size']);
            $basket->setPrice($basket['price']);
            $this->entity_manager->persist($basket);
            $this->entity_manager->flush();
            $baskets[] = $basket;
        }
        return $baskets;
    }
    {
        # code...
    }
}
