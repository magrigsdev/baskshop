<?php

namespace App\Tests;

use App\Entity\Baskets;
use App\imports\Ingest;
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

    public function testImportBaskets(): void
    {
        $json = $this->project_dir.'/var/json/basket.json';
        $basket_import = new Ingest();
        $basket_imported = $basket_import->getJson($json);
        $this->assertNotEmpty($basket_imported, 'array of baskets');
    }

    public function testSaveBasket(): void
    {
        $json = $this->project_dir.'/var/json/basket.json';
        $basket_import = new Ingest();
        $basket_imported = $basket_import->getJson($json);
        $basket_service = new BasketsServices($this->entity_manager, $this->project_dir);
        $saveBaskets = $basket_service->saveBaskets($basket_imported);
        $this->assertNotFalse($saveBaskets);
    }
}
