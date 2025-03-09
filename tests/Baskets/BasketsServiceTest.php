<?php

namespace App\Tests;

use App\Entity\Baskets;
use App\Services\BasketsServices;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BasketsServiceTest extends KernelTestCase
{
    private $entity_manager;
    private $basket_repository;
    private $project_dir;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $container = static::getContainer();
        $this->entity_manager = $container->get('doctrine.orm.entity_manager');
        $this->basket_repository = $this->entity_manager->getRepository(Baskets::class);
        $this->project_dir = $container->getParameter('kernel.project_dir');
    }

    protected function tearDown(): void
    {
        $baskets = $this->basket_repository->findAll();
        foreach ($baskets as $basket) {
            $this->entity_manager->remove($basket);
        }
        $this->entity_manager->flush();
        parent::tearDown();
    }

    public function testGetBaskets(): void
    {
        $json = $this->project_dir.'/var/json/baskets.json';
        if (!file_exists($json)) {
            throw new \Exception('File not found', 1);
        }
        $basket_service = new BasketsServices($this->entity_manager, $this->project_dir);
        $baskets = $basket_service->getBasketsFromFile($json);
        // dump($users);
        $this->assertNotEmpty($baskets, 'array of baskets');
    }

    public function testPutBasket(): void
    {
        $json = $this->project_dir.'/var/json/baskets.json';
        if (!file_exists($json)) {
            throw new \Exception('File not found', 1);
        }
        $basket_service = new BasketsServices($this->entity_manager, $this->project_dir);
        $baskets = $basket_service->getBasketsFromFile($json);

        // dump($baskets);
        $putBaskets = $basket_service->putBasketsIntoDatabase($baskets);
        $this->assertNotFalse($putBaskets);
    }
}
