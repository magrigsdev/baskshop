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
            // Vérifiez que chaque élément de $baskets est un tableau
            if (!is_array($basket)) {
                throw new \Exception('Invalid basket format: expected array, got '.gettype($basket));
            }

            // Créez un nouvel objet Baskets et définissez ses propriétés
            $new_basket = (new Baskets())
                ->setBrand($basket['brand'])
                ->setColor($basket['color'])
                ->setName($basket['name'])
                ->setSize($basket['size'])
                ->setPrice($basket['price']);
            // Persistez l'objet dans la base de données
        }
        $this->entity_manager->persist($new_basket);
        // Effectuez un flush après avoir persisté tous les objets
        $this->entity_manager->flush();

        return true;
    }
}
