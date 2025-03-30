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

    public function saveBaskets(array $baskets): bool
    {
        if (empty($baskets)) {
            throw new \Exception('No baskets to insert');
        }
        foreach ($baskets as $basket) {
            if (!is_array($basket)) {
                throw new \Exception('Invalid basket format: expected array, got '.gettype($basket));
            }
            $new_basket = (new Baskets())
                ->setBrand($basket['brand'])
                ->setColor($basket['color'])
                ->setName($basket['name'])
                ->setSize($basket['size'])
                ->setPrice($basket['price']);
            $this->entity_manager->persist($new_basket);
        }
        $this->entity_manager->flush();
        $this->entity_manager->clear();

        return true;
    }
}
