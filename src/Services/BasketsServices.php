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
            $new_basket = new Baskets();
            $new_basket->setBrand($basket['brand'] );
            $new_basket->setName($basket['name'] );
            $new_basket->setColor($basket['color'] );
            $new_basket->setSize($basket['size'] );
            $new_basket->setPrice($basket['price'] );
            $this->entity_manager->persist($new_basket);
            echo "basket service ...";
            dump($new_basket);
        }
        try {
            $this->entity_manager->flush();
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Error saving baskets: '.$e->getMessage());
        }
    }
}
