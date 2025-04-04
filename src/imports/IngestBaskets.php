<?php 


namespace App\imports;
class IngestBaskets extends Ingest
{
    public function __construct()
    {
        // parent::__construct(); // Removed as Ingest::__construct() does not exist
    }

    public function get(string $json_file): array
    {
        $baskets_imported = parent::get($json_file);
        $baskets = [];

        foreach ($baskets_imported as $item) {
            $basket = new \App\Entity\Baskets();
            $basket->setBrand($item['brand']);
            $basket->setColor($item['color']);
            $basket->setName($item['name']);
            $basket->setSize($item['size']);
            $basket->setPrice($item['price']);
            $baskets[] = $basket;
        }

        return $baskets;
    }
}